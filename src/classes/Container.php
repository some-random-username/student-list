<?php
namespace src\classes;

class Container implements \ArrayAccess {
    private $values = [];
    
    public function __construct() { 
        $this->registerDefaults();
    }
    
    public function registerDefaults() {
        $this->values['settings'] = function(Container $container) {
            return include(CONFIGPATH);
        };
        
        $this->values['router'] = function(Container $container) {
            return new Router($container, $container['settings']);
        };
        
        $this->values['url'] = function() {
            return trim($_SERVER['REQUEST_URI'], '/');
        };
        
        $this->values['db'] = function(Container $container) {
            return new Db($container['settings']);
        };
        
        $this->values['StudentsModel'] = function(Container $container) {
            return new \src\models\StudentsModel($container['db']);
        };
        
        $this->values['StudentsValidator'] =  function(Container $container) {
            return new \src\helpers\validators\StudentsValidator($container);
        };
    }
    
    public function offsetExists($offset) {
        return isset($this->values[$offset]);
    }
    
    public function offsetGet($offset) {
        if(isset($this->values[$offset])) { 
            $raw = $this->values[$offset];
            $val  = $raw($this);
            return $val;
        }
        return null;
    }
    
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->values[] = $value;
        } else {
            $this->values[$offset] = $value;
        }
    }
    
    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }
}
