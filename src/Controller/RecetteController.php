<?php
namespace src\Controller;

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
        $diet = new Diet();
        $unity = new Unity();
        $combien = intval($_POST["combien"]);
        return $this->twig->render("Recette/addRecette2.html.twig",[
            "diets" => $diet->getAllDiet(),
            "unities" => $unity->getAllUnity(),
            "combien" => $combien
        ]);
    }

    public function AddRecipe(){
        var_dump($_POST);
        $recipeName = $_POST["recipename"];
        $people = $_POST["howmany"];
        $diet = $_POST["diet"];
        $ingredients = $_POST["ingredient"];
        $quantity = $_POST["quantite"];
        $unity = $_POST["unity"];
        $recipeDescription = $_POST["recipestep"];
        var_dump($recipeName,$people,$diet,$ingredients,$quantity,$unity,$recipeDescription);

    }





}