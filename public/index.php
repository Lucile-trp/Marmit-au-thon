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
$URLS = explode("/",$_GET["url"]);
$controller= (isset($URLS[0])) ? $URLS[0] : '';
$action = (isset($URLS[1])) ? $URLS[1] : '';
$param = (isset($URLS[2])) ? $URLS[2] : '';

if($controller != ''){
    $class = "src\Controller\\".$controller."Controller";
    if(class_exists($class)){
        $controller = new $class;
        if(method_exists($class,$action)){
            echo $controller->$action($param);
        }else{
            //Le controller existe mais pas la fonction dans le controller (page 404)
            echo $controller->index();
        }
    }else{
        // Le controller n'existe pas (page 404)
        $controller = new src\Controller\NotFoundController();
        echo $controller->index();
    }
}else{
    //Page home
    $controller = new src\Controller\HomeController();
    echo $controller->index();
}