<?php
namespace src\classes;


abstract class Controller 
{
    protected $template;
    protected $container;
    protected $model;
    protected $validator;
    
    public function __construct(Template $template, Container $container) {
        $this->template = $template;
        $this->container = $container;
    }
    
    public function setValidator(\src\helpers\validators\Validator $validator) {
        $this->validator = $validator;
    }
    
    public function setModel($model) {
        $this->model = $model;
    }
    
    public function getParams() {
        printArray($this->routeParams);
        echo '<br>';
    }
}
