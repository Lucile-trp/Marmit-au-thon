<?php
require ("../vendor/autoload.php");

// Autoloader de classes
function chargerClasse($classe){
    $ds = DIRECTORY_SEPARATOR;
    $dir = __DIR__."$ds..";
    $classePath = str_replace("\\", $ds,$classe);
    $file = "{$dir}{$ds}{$classePath}.php";
    if(is_readable($file)){
        require_once $file;
    }
}

spl_autoload_register("chargerClasse");

// Router
$controller = (isset($_GET["controller"])) ? $_GET["controller"] : "";
$action = (isset($_GET["action"])) ? $_GET["action"] : "";
$param = (isset($_GET["param"])) ? $_GET["param"] : "";

if($controller != ''){
    $class = "src\Controller\\".$controller."Controller";
    if(class_exists($class)){
        $controller = new $class;
        if(method_exists($class, $action)){
            echo $controller->$action($param);
        }else{
            echo $controller->index();
        }
        }else{
            $controller = new src\Controller\NotFoundController();
            echo $controller->index();
        }

    }else{
        $controller = new src\Controller\NotFoundController();
        echo $controller->index();
}