<?php
namespace src\Controller;

use src\Model;
use src\Model\BDD;


class IngredientController extends AbstractController{

    public function search(){
        $newIngredient= new Model\Ingredient();
        if(isset($_POST['addIngredient'])){
            $search = $_POST["search"];
            $ingredient=$newIngredient->getIngredientBySearch(BDD::getInstance(),$search);
            var_dump($newIngredient);
            var_dump($search);
            var_dump($_GET);
        }
    }

}