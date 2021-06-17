<?php
namespace src\Controller;

use src\Model\Recette;
use src\Model\Blog;

class HomeController extends AbstractController
{
    public function index(){
        $number = 8;
        $recipe = new Recette();
        // Le paramètre est le nom de recettes que l'ont veut afficher sur la page
        $recipes = $recipe->getRecipes($number);

        $article = new Blog();
        $article = $article->getThree();

        return $this->twig->render("home/index.html.twig",[
            "recipes" => $recipes,
            "number" => $number,
            "articles"=>$article
        ]);

    }



}