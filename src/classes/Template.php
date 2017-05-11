<?php
namespace src\classes;

class Template 
{
    public function __construct() {
    }
    
    public function render($file, $params = []) {
        $path = '../src/views/';
        $file = $path . $file . '.php';
        if(file_exists($file)) {
            include('../src/views/header.php');
            include($file);
            include('../src/views/footer.php');
        }
    }
}
