<?php
namespace src\Controller;

use src\Model\Recette;
use src\Model\BDD;


class PanierController extends AbstractController {
    public function index(){
        session_start();

        return $this->twig->render("Panier/panier.html.twig",  [
            "panier" => $_SESSION['panier']
        ]);
    }

    public function addPanier($id){
        $bdd = BDD::getInstance();

        session_start();
        //
       // session_unset();

        $recipe = Recette::getRecipeFromId($bdd, $id);

        $_SESSION['panier'][$id] = array(
            'recname'=> $recipe[0]['recname'],
            'ingredient' => []
        );

        foreach ($recipe as $ingredient ){
            $temparraying = array(
                'ingname' => $ingredient['ingname'],
                'joinquantite' => $ingredient['joinquantite'],
                'uniname' => $ingredient['uniname']
            );
            array_push($_SESSION['panier'][$id]['ingredient'], $temparraying);
        }
        return $this->twig->render("Panier/panier.html.twig", [
            "panier" => $_SESSION['panier']
        ]);
    }


}