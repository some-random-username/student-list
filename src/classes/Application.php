<?php
namespace src\classes;
use src\classes\Container;

class Application 
{
    private $container;
            
    public function __construct(Container $container) {
        $this->container = $container;
    }   
    
    public function run() {
        $router = $this->container['router'];
        $router->getControllerObj($this->container['url']);
        /*$router = new Router($this->settings['routes']);
        if($controller = $router->getControllerObj($this->settings['url'])) {
            //$controller->getParams();
        } */
    }
}
