<?php
namespace src\Controller;

use src\Model\Recette;
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
        if (!empty($_POST && $_FILES)){
            // Gestion de l'image de la recette
            $tabExt = ['jpg','png','jpeg'];
            $extension = pathinfo($_FILES['recipe-img']['name'], PATHINFO_EXTENSION);
            if (in_array(strtolower($extension),$tabExt)){
                $imageName = md5(uniqid()) . '.' . $extension;
                $dateNow = new \DateTime();
                $imageFolder = "./uploads/recipe-images/" . $dateNow->format("Y/m");
                if (!is_dir($imageFolder)){
                    mkdir($imageFolder,0777,true);
                }
                // Déplacement de l'image dans /public/uploads/recipe-images/année-courante/mois-courant/nom-image
                move_uploaded_file($_FILES["recipe-img"]["tmp_name"], $imageFolder . "/" . $imageName);
            }

            // Récupération des informations de la recette
            $recipeName = $_POST["recipename"];
            $people = $_POST["howmany"];
            $diet = $_POST["diet"];
            $ingredients = $_POST["ingredient"];
            $quantity = $_POST["quantite"];
            $unity = $_POST["unity"];
            $recipeDescription = $_POST["recipestep"];
            $recipeImage = $imageFolder . $imageName;

            // Instanciation d'une nouvelle recette
            $recipe = new Recette();

            // Insertion de la recette dans la base de données.
            $recipe->insertRecipe($recipeName,$recipeImage,$people,$diet,$ingredients,$quantity,$unity,$recipeDescription);
        }
    }

    public function show(){
        $recipe = new Recette();
        return $this->twig->render("Recette/show.html.twig",[
            "recipes" => $recipe->getRecipe()
        ]);
    }





}