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

    public function Add(){
        //On protège le système grâce à la fonction RoleNeeded qu'on a définie dans UserController
        //UserController::RoleNeeded("rédacteur");

        if(isset($_POST["Titre"])){
            // Traiter le formulaire (ajout en BDD)
            $article = new Article();
            $dateDuJour=new \DateTime();
            $article->setTitre($_POST["Titre"]);
            $article->setDescription($_POST["Description"]);
            $article->SetAuteur($_POST["Auteur"]);
            $article->setDateAjout($dateDuJour->format("Y-m-d"));
            $result = $article->SqlAdd();
            if($result == "ok"){
                // Redirection
                header("location:/?controller=Article&action=List");
            }else{
                // Message d'erreur en Session et affichage du formulaire
                return $this->twig->render("error.html.twig",[
                    "error"=>$result
                ]);
            }
        }else{
            // Afficher le formulaire HTML
            return $this->twig->render("Article/add.html.twig");
        }
    }

}