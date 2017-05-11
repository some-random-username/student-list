<?php
const CONFIGPATH = '../src/config.php';
use src\classes\Application;
use src\classes\Container;

error_reporting(E_ALL);

spl_autoload_register(function($class) {
    $root = dirname(__DIR__);
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if(is_readable($file)) {
        require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if(error_reporting() !== 0) {
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
});

set_exception_handler(function($exception) {
    $code = $exception->getCode();
    http_response_code($code);
    
    $prod = false;
    if(!$prod) {
    echo "<h1>Fatal error</h1>";
    echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
    echo "<p>Message: '" . $exception->getMessage() . "'</p>";
    echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
    echo "<p>Thrown in '" . $exception->getFile() . "' on line " . 
            $exception->getLine() . "</p>";
    } else {
        switch ($code) {
            case "404":
                include '../src/views/404.php';
                break;
            case "403":
                include '../src/views/403.php';
                break;
            default :
                include '../src/views/500.php';
                break;
        }
    }
});

$container = new Container();
$app = new Application($container);
$app->run();



