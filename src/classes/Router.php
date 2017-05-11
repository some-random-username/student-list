<?php
namespace src\classes;
use Exception;

class Router 
{  
    private $routes = [];  
    private $params = [];
    private $container;
    
    public function __construct(Container $container, $settings = []) {
        $this->container = $container;
        if(!empty($settings['routes'])) {
            foreach($settings['routes'] as $route => $params) {
                $this->addRoute($route, $params);
            }
            return true;
        }
        throw new Exception("Router settings are empty");
    }
    
    public function addRoute($route, $params = []) {
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';
        $this->routes[$route] = $params;
    }
    
    public function getRoutes() {
        return $this->routes;
    }
    
    public function getControllerObj($url) {
        $url = $this->removeQuery($url);
        if($this->match($url)) {
            $controller = ucfirst($this->params['controller']);
            $controller = "\src\controllers\\$controller";
            $action = $this->params['action'];
            if(class_exists($controller)) {
                $templateObj = new Template();
                $controllerObj = new $controller($templateObj, $this->container);
                if(method_exists($controllerObj, $action)) {
                    $controllerObj->$action();
                    
                    return $controllerObj;
                }
                throw new Exception("There is no action $action in " . get_class($controllerObj) . " object", 500);
            }  
        }
        throw new Exception("No match", 404);
    }
    
    public function match($url) {
        if(!empty($this->routes)) {
            foreach($this->routes as $route => $params) {
                if(preg_match($route, $url, $matches)) {
                    if(empty($params)) {
                        foreach($matches as $key => $value) {
                            if(is_string($key)) {
                                $this->params[$key] = $value;
                            }
                        }
                        return true;   
                    }
                    $this->params = $params;
                    return true;
                }            
            }
            return false;
        }
    }
    
    public function removeQuery($url) {
        if($url != '') {
            $pieces = explode('?', $url, 2);
            
            if(strpos($pieces[0], '=') === false) {
                $url = $pieces[0];
            } else {
                $url = '';
            }
            return $url;
        }
    }
}
