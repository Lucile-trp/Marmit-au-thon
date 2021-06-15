<?php
namespace src\Controller;

use src\Model\Recette;
use src\Model\BDD;


class PanierController extends AbstractController {
    public function index(){
        session_start();
        if (!isset($_SESSION['panier'])){
            $_SESSION['panier'] = null;
        }
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
            'id' => $id,
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
        header('Location: /Recette/listing' );
    }

    //Reset tout le panier
    public function resetPanier(){
        session_start();
        unset($_SESSION['panier']);
        header('Location: /Panier/index');
    }

    //Enlève une recette et ses ingrédients du panier
    public function unsetOne($id){
        session_start();
        unset($_SESSION['panier'][$id]);
        header('Location: /Panier/index');


    }


}