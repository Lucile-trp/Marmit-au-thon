<?php
namespace src\Controller;
use src\Model\Blog;

class BlogController extends AbstractController
{
    public function index(){
        //Définit le nom de la session avant de la démarrer
        session_name("admin");
        session_start();
        $article = Blog::getAll();
        return $this->twig->render("Blog/blog.html.twig", [
            "articles" => $article,
            "session" => $_SESSION,
        ]);
    }

    //Fonction de redirection à la page du formulaire
    //ON DOIT AVOIR LE ROLE ADMIN
    public function addForm(){
        return $this->twig->render("Blog/Add.html.twig");

    }


    //affiche les détails d'un article
    public function detail($slug){
        $article = Blog::getOne($slug);
        return $this->twig->render("Blog/detail.html.twig",[
                "article" => $article
            ]);

    }

    //Fonction d'ajout d'un article en BDD
    public function addArticle(){
        $datas = $_POST;
        if($datas['art-title'] != "" && $datas['art-resume'] != "" && $datas['art-content'] != "" && !empty($_FILES)){
            Blog::insertArticle($datas, $_FILES);
            header('Location: /Blog/index');
        } else {
            $error = "Il y a une erreur dans les informations";
            return $this->twig->render("Blog/Add.html.twig",[
                "error_message" => $error,
            ]);

        }

    }

    //Fonction qui supprime un article
    public function deleteArticle($id){
        //TODO Verification du rôle (admin ou redacteut
        Blog::deleteArticle($id);
        header('Location: /Blog/index');

    }

    //Fonction qui récupère les informations de l'article à modifier et qui renvoie au formulaire.
    public function getDetailsForUpdate($slug){
        $article = Blog::getOne($slug);
        return $this->twig->render("Blog/updateForm.html.twig", [
            "article" => $article
        ]);

    }

    //Fonction qui met à jour en BDD l'article choisi.
    public function updateArticle($id){
        //TODO Verification admin ou redacteur
        $datas = $_POST;

        if($datas['art-title'] != "" && $datas['art-resume'] != "" && $datas['art-content']){
            Blog::updateArticle($datas);
            $article = Blog::getAll();
            return $this->twig->render("Blog/blog.html.twig", [
                "articles" => $article,
                "success_message" => "Votre article à bien été modifié"
            ]);
        } else {
            $error = "Il y a une erreur dans les informations";
            return $this->twig->render("Blog/updateForm.html.twig",[
                "error_message" => $error,
            ]);

        }


    }


    //TODO
    // Add feature modify article (ADMIN)
}