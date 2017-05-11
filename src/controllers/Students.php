<?php
namespace src\controllers;
use src\classes\Controller;


class Students extends Controller
{
    public function __construct($template, $container) {
        parent::__construct($template, $container);
        $model = $this->container['StudentsModel'];
        $validator = $this->container['StudentsValidator'];
        $this->setModel($model);
        $this->setValidator($validator);
    }
    
    public function index() { 
        if(isset($_GET['find'])) {
            $findParam = $_GET['find'];
            $data = $this->model->findStudent($findParam);
            
            if($data === false) {
                $this->template->render('students/notfound');
            }  else {
                $this->template->render('students/index', array('students' => $data['students']));
            }
            return true;
        }
        
        $data = $this->model->getAllStudents();
        $this->template->render('students/index', array('students' => $data['students'], 'paginatorData' => $data)); 
        }
    
    public function add() {
        if(isset($_GET['status']) and $_GET['status'] == 'added') {
            $this->template->render('students/added');
            die;
        }
        
        if(isset($_GET['status']) and $_GET['status'] == 'edited') {
            $this->template->render('students/edited');
            die;
        }
        
        if($this->model->authorize($_COOKIE)) {
            if(!empty($_POST)) {
                $errors = $this->validator->validate($_POST);
                if(empty($errors)) {
                    $this->model->editStudent($_POST, $_COOKIE);
                    header('Location: ' . $_SERVER['REQUEST_URI'] . '?status=edited');
                } else {
                    $this->template->render('students/add', array('errors' => $errors, 'values' => $_POST));
                    die;
                }  
            }
            $id = $this->model->getStudentIdBySalt($_COOKIE['key']);
            $this->template->render('students/edit', array('values' => $this->model->getStudentArrayById($id)));
            die;
        }
        
        if(!empty($_POST)) {
            $errors = $this->validator->validate($_POST);
            $emailErrors = $this->validator->checkEmail($_POST['email']);
            if(!empty($emailErrors))  {
                $errors[] = $emailErrors;
            }
            
            if(empty($errors)) {
                $this->model->addNewStudent($_POST);
                header('Location: ' . $_SERVER['REQUEST_URI'] . '?status=added');
            } else {
                $this->template->render('students/add', array('errors' => $errors, 'values' => $_POST));
            }           
        } else {
            $this->template->render('students/add');
        }
    }
    
    public function delete() {
        echo "Мы в методе Delete!";
    }
}
