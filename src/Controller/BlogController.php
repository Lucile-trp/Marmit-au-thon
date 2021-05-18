<?php
namespace src\Controller;
use src\Model\Blog;

class BlogController extends AbstractController
{
    public function index(){

        $article = Blog::getAll();
        return $this->twig->render("Blog/blog.html.twig", [
            "articles" => $article
        ]);
    }

    //Fonction de redirection à la page du formulaire
    //ON DOIT AVOIR LE ROLE ADMIN
    public function addForm(){
        return $this->twig->render("Blog/Add.html.twig");

    }

    //Fonction d'ajout d'un article
    public function add(){

    }

    //affiche les détails d'un article
    public function detail($id){
        $article = Blog::getOne($id);
        return $this->twig->render("Blog/detail.html.twig",[
                "article" => $article
            ]);

    }
}