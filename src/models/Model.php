<?php
namespace src\models;
use src\classes\Db;

abstract class Model {
    protected $db;
    protected $pdo;
    
    public function __construct(Db $db) {
        $this->db = $db;
    }
    
    public function setPdo($pdo) {
        $this->pdo = $pdo;
    }
}
