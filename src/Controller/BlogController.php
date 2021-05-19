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


    //affiche les détails d'un article
    public function detail($id){
        $article = Blog::getOne($id);
        return $this->twig->render("Blog/detail.html.twig",[
                "article" => $article
            ]);

    }

    //Fonction d'ajout d'un article en BDD
    public function addArticle(){
        $datas = $_POST;

        if($datas['art-title'] != "" && $datas['art-resume'] != "" && $datas['art-content'] != ""){
            $result = Blog::insertArticle($datas);
            var_dump($result);

        } else {
            $error = "Il y a une erreur dans les informations";
            return $this->twig->render("Blog/Add.html.twig",[
                "error_message" => $error,
            ]);

        }

    }
}