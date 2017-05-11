<?php
namespace src\models;
use src\helpers\md5;

class StudentsModel extends Model
{
    public function __construct(\src\classes\Db $db) {
        parent::__construct($db);
    }
    
    public function getAllStudents($sort = 'ege') {
        $params = [];
        $per_page = 10;
        $cur_page = 1;
        
        if(isset($_GET['page']) && $_GET['page'] > 0) {
            $cur_page = intval($_GET['page']);
        }
        $start = ($cur_page - 1) * $per_page;
        
        $query = $this->db->run("SELECT * FROM students "
                . "ORDER BY $sort DESC LIMIT ?, ?", 
                array($start, $per_page));
        
        $students = [];
        while ($row = $query->fetch()) {
            $params['students'][$row['id']]['name'] = $row['name'];
            $params['students'][$row['id']]['lastname'] = $row['lastname'];
            $params['students'][$row['id']]['groupnum'] = $row['groupnum'];
            $params['students'][$row['id']]['ege'] = $row['ege'];
        }
        
        $rows = $this->db->run("SELECT COUNT(*) FROM students");
        $rows = $rows->fetch()['COUNT(*)'];
        
        $num_pages = ceil($rows / $per_page);
        $page = 0;
        
        $params['cur_page'] = $cur_page;
        $params['page'] = $page;
        $params['num_pages'] = $num_pages;
        return $params;
    }
     
    public function addNewStudent($parameters) {
        $salt = md5::generateSalt(0, 32);
        $stmt = $this->db->run('INSERT INTO `students` '
                . '(`id`, `name`, `lastname`, `groupnum`, `gender`, `email`, `ege`, `birth`, `local`, `salt`)'
                . ' VALUES (NULL, :name, :lastname, :groupnum, :gender, :email, :ege, :birth, :local, :salt);',
                array(
                    ':name' => $parameters['name'], ':lastname' => $parameters['lastname'], 
                    ':groupnum' => $parameters['groupnum'], ':gender' => $parameters['gender'], 
                    ':email' => $parameters['email'], ':ege' => $parameters['ege'], 
                    ':birth' => $parameters['birth'], ':local' => $parameters['local'], ':salt' => $salt
                     )
                );
        setcookie('key', $salt, time()+(31556926*10), '/', null, false, true);
        return true;
    }
    
    public function findStudent($findParam) {
        $stmt = $this->db->run('SELECT * FROM students '
                . 'WHERE name LIKE :find OR lastname LIKE :find1 OR groupnum LIKE :find2 OR ege LIKE :find3',
                array(
                    ':find' => '%'.$findParam.'%', ':find1' => '%'.$findParam.'%', 
                    ':find2' => '%'.$findParam.'%', ':find3' => '%'.$findParam.'%'
                    )
                );
        
        if($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch())
            {
                $params['students'][$row['id']]['name'] = $row['name'];
                $params['students'][$row['id']]['lastname'] = $row['lastname'];
                $params['students'][$row['id']]['groupnum'] = $row['groupnum'];
                $params['students'][$row['id']]['ege'] = $row['ege'];
            }
            return $params;
        }
        return false;
    }
    
    public function editStudent($values, $cookie) {
        $params = [];
        $id = $this->getStudentIdBySalt($cookie['key']);
        $studentArray = [];
        
        foreach($values as $key => $value) {
            $studentArray[$key] = $value;
        }
        
        $pdo = $this->db;
        $stmt = $pdo->run("UPDATE students SET name=?, lastname=?, groupnum=?,"
                . "gender=?, email=?, ege=?, birth=?, local=? WHERE id=?", 
                array(
                    $studentArray['name'],
                    $studentArray['lastname'],
                    $studentArray['groupnum'],
                    $studentArray['gender'],
                    $studentArray['email'],
                    $studentArray['ege'],
                    $studentArray['birth'],
                    $studentArray['local'],
                    $id
                    )
                );
    }
    
    public function getStudentArrayById($id) {
        $list = $this->db->run("SELECT * FROM students WHERE id=?", array($id));
        $row = $list->fetch();
        $student['name'] = $row['name'];
        $student['lastname'] = $row['lastname'];
        $student['groupnum'] = $row['groupnum'];
        $student['gender'] = $row['gender'];
        $student['email'] = $row['email'];
        $student['ege'] = $row['ege'];
        $student['birth'] = $row['birth'];
        $student['local'] = $row['local'];
        
        return $student;
    }
    
    public function getStudentIdBySalt($salt) {
        $stmt = $this->db->run("SELECT id FROM students WHERE salt=?", array($salt));
        $id = $stmt->fetch();
        return $id['id'];
    } 
    
    public function authorize($cookie) {
        if(isset($cookie['key'])) {
            $salt = $cookie['key'];
            $stmt = $this->db->run("SELECT * FROM students WHERE salt=?", array($salt));
            if($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        }
    }
   
}
