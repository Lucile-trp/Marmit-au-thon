<?php


namespace src\Controller;


use src\Model\Admin;
use src\Model\Blog;
use src\Model\Recette;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AdminController extends AbstractController
{
    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * Affiche le formulaire de connexion de la page Admin
     */
    public function login(){
        return $this->twig->render("/Admin/login.html.twig");
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * Vérifie si l'utilisateur a la rôle admin
     */
    public function checkLogin(){
        $mail = htmlentities($_POST["climail"]);
        $password_clear = htmlentities($_POST["clipassword"]);

        $admin = new Admin();
        $password_encrypted = $admin->getAdminAccount($mail)["clipassword"];
        $checkPassword = password_verify($password_clear,$password_encrypted);

        $isAdmin = $admin->isAdmin($mail);

        if ($isAdmin === true && $checkPassword === true){
            header("Location: /Admin/index");
        }else{
            header("Location: /Admin/login");
        }
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * Affiche la page d'admin qui contient l'ensemble des éléments du site
     */
    public function index(){
        session_start();
        if (empty($_SESSION["admin"])){
            header("Location: /Admin/login");
        }
        else{
            $admin = new Admin();
            $blog = new Blog();
            $recipe = new Recette();
            return $this->twig->render("/Admin/index.html.twig", [
                "customers" => $admin->getAllActivesClients(),
                "articles" => $blog->getAll(),
                "recipes" => $recipe->getAllRecipes()
            ]);
        }
    }

    /**
     * @param $id
     * Supprime un utilisateur par rapport à son ID
     */
    public function deleteUser($id){
        $admin = new Admin();
        $delete = $admin->deleteUserById($id);
        if ($delete === true){
            header("Location: /Admin/index");
        }else{
            echo "impossible à supprimer";
        }
    }

    /**
     * @param $id
     * Supprime un ID par rapport à son ID
     */
    public function deleteArticle($id){
        $blog = new Blog();
        $delete = $blog->deleteArticle($id);

        if ($delete === true){
            header("Location: /Admin/index");
        }
        else{
            echo "Suppression de l'article impossible";
        }
    }

    /**
     * @param $id
     * Supprime une recette par rapport à son ID
     */
    public function deleteRecipe($id){
        $recipe = new Recette();
        $delete = $recipe->deleteRecipe($id);

        if ($delete === true){
            header("Location: /Admin/index");
        }
        else{
            echo "Suppression de l'article impossible";
        }
    }
}