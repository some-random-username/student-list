<?php
namespace src\classes;
use Exception;
use PDO;

class Db 
{
    private $dbSettings;
    private $pdo;
    
    public function __construct($settings) { 
        if(!empty($settings['db'])) {
            $this->dbSettings = $settings['db'];
        } else {
            throw new Exception("Db settings not found", 500);
        }
        $this->setConnection();
    }
    
    private function setConnection() {
        $host = $this->dbSettings['host'];
        $db = $this->dbSettings['name'];
        $user = $this->dbSettings['user'];
        $pass = $this->dbSettings['pass'];
        $charset = $this->dbSettings['charset'];
        
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        $this->pdo = new PDO($dsn, $user, $pass, $opt);
    }
    
    public function getConnection() {
        return $this->pdo;
    }
    
    public function run($sql, $args = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}
