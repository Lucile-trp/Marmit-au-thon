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
        return $this->twig->render("Recette/addRecette.html.twig");

    }
    public function formAdd(){
        var_dump($_POST);
        $diet=new Diet();
        $unity=new Unity();
        $combien=intval($_POST['combien']);
        return $this->twig->render("Recette/addRecette2.html.twig",[
            "diets"=>$diet->getAllDiet(),
            "unities"=>$unity->getAllUnity(),
            "combien"=>$combien
        ]);
    }

    public function AddRecipe(){
        var_dump($_POST);
        $dietname=$_POST['diet'];
        $howmany=$_POST['rechowmany'];
        $recname=$_POST['recname'];
        $recimg=$_POST['recimg'];
        $unity[]=$_POST['unity'];
        $ingredient[]=$_POST['ingredient'];
        $quantite[]=$_POST['quantite'];

    }





}