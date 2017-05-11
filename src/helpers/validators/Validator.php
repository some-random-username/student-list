<?php
namespace src\helpers\validators;

abstract class Validator 
{
    protected $db;
    
    public function __construct($container) {
        $this->db = $container['db'];
    } 
    
    abstract function validate($values);
}
