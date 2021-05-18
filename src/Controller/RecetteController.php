<?php
namespace src\Controller;

use src\Controller\AbstractController;
use src\Model\Diet;
use src\Model\Unity;

class RecetteController extends AbstractController {
    public function index(){
        echo "page recette";
    }

    public function add(){
        $diet=new Diet();
        $unity=new Unity();

        return $this->twig->render("Recette/addRecette.html.twig",["diets"=>$diet->getAllDiet(),"unities"=>$unity->getAllUnity()]);

    }
    public function checkRecette(){
        var_dump($_POST);
        return $this->twig->render("Recette/addRecette2.html.twig");
    }





}