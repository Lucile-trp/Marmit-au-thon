<?php
namespace src\Controller;

use src\Controller\AbstractController;

class RecetteController extends AbstractController {
    public function index(){
        echo "page recette";
    }

    public function new(){
      
      /*  if(isset($_POST["recname"])){
            //Traiter le formulaire = ajouter la recette en BDD
            $recipe=new Recette;
            $recipe->setTitre($_POST["recname"]);
            $result=$recipe->SqlAdd(BDD::getInstance());
            if($result =="ok"){
                //Redirection
            }else{
                //Msg d'erreur
            }
        }else{

        }
        //Afficher le formulaire
    }*/
    }
}