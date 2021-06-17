<?php
namespace src\Controller;

use src\Model\Recette;
use src\Model\Diet;
use src\Model\Unity;
use src\Model\Client;
use Dompdf\Dompdf;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
            $recipeImage = $imageFolder . '/' .  $imageName;

            // Instanciation d'une nouvelle recette
            $recipe = new Recette();

            // Insertion de la recette dans la base de données
            $recipe->insertRecipe($recipeName,$recipeImage,$people,$diet,$ingredients,$quantity,$unity,$recipeDescription);
        }
        else{
            echo "Erreur fonction AddRecipe, POST ou FILES vide.";
            var_dump($_POST);
            var_dump($_FILES);
        }
        header("Location: /Recette/listing");
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * Affiche une page recette en fonction de l'id donné en paramètre (à rajouter)
     */
    public function oneRecipe($slug){
        $recipe = new Recette();
        $recipes = $recipe->getRecipeBySlug($slug);

        $idrecipe = $recipes[0]["idrecipe"];
        $recipeName = $recipes[0]["recname"];
        $recipeSlug = $recipes[0]["recnameslug"];
        $recipeImg = $recipes[0]["recimg"];
        $idClient = $recipes[0]["recidclient"];
        $nbrePersonne = $recipes[0]["rechowmany"];
        $recipeDesc = $recipes[0]["rectext"];

        $tabIngredients = [];
        foreach ($recipes as $recipe){
            $tabIngredients [] = [
                "ingredientName" => $recipe["ingname"],
                "quantity" => $recipe["joinquantite"],
                "unity" => $recipe["uniname"]
            ];
        }

        return $this->twig->render("Recette/oneRecipe.html.twig",[
            "idrecipe" => $idrecipe,
            "recipename" => $recipeName,
            "recipeslug" => $recipeSlug,
            "recipeimg" => $recipeImg,
            "idClient" => $idClient,
            "peoples" => $nbrePersonne,
            "recipedesc" => $recipeDesc,
            "ingredients" => $tabIngredients,
        ]);
    }

    public function send_mail(){
        ini_set('SMTP','localhost');
        ini_set('smtp_port','25');
        try {
            $mailTest = mail(
                'toto@gmail.com',
                'Test mail',
                'ceci est un message',
                'From: test@marmitothon.fr'
            );
            echo "C'est bon";
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
    /**
     * Affiche une page avec un ensemble de recette
     */
    public function listing(){
        $number = 12;
        $recipe = new Recette();
        // Le paramètre est le nom de recettes que l'ont veut afficher sur la page
        $recipes = $recipe->getRecipes($number);

        return $this->twig->render("Recette/listing.html.twig",[
            "recipes" => $recipes,
            "number" => $number
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * Génère une vue Twig qui sera utilisée par la fonction generatePdf
     */
    public function renderTwigForPdf($id){
        $recipe = new Recette();
        // Remplacer par $id
        $recipes = $recipe->getRecipeByIdRecipe($id);

        $idrecipe = $recipes[0]["idrecipe"];
        $recipeName = $recipes[0]["recname"];
        $recipeSlug = $recipes[0]["recnameslug"];
        $recipeImg = $recipes[0]["recimg"];
        $idClient = $recipes[0]["recidclient"];
        $nbrePersonne = $recipes[0]["rechowmany"];
        $recipeDesc = $recipes[0]["rectext"];

        $tabIngredients = [];
        foreach ($recipes as $recipe){
            $tabIngredients [] = [
                "ingredientName" => $recipe["ingname"],
                "quantity" => $recipe["joinquantite"],
                "unity" => $recipe["uniname"]
            ];
        }

        return $this->twig->render("Recette/recipe_pdf.html.twig",[
            "idrecipe" => $idrecipe,
            "recipename" => $recipeName,
            "recipeslug" => $recipeSlug,
            "recipeimg" => $recipeImg,
            "idClient" => $idClient,
            "peoples" => $nbrePersonne,
            "recipedesc" => $recipeDesc,
            "ingredients" => $tabIngredients,
        ]);
    }

    /**
     * @param $id
     * Génère une PDF de la recette qui correspond à l'id donné en paramètre
     */
    public function generatepdf($id){
        try {
            $dompdf = new Dompdf();
            $recette = new Recette();

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'portrait');
            // J'utilise la fonction details() pour générer le contenu du pdf à remplacer par renderTwigForPdf
            $dompdf->loadHtml($this->renderTwigForPdf($id));

            // Render the HTML as PDF
            $dompdf->render();
            $slug = $recette->getRecipeSlug($id)["recnameslug"];
            // Output the generated PDF to Browser
            $dompdf->stream($slug . ".pdf");
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }

}