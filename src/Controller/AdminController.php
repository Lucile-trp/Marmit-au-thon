<?php


namespace src\Controller;


use src\Model\Admin;
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
            header("Location : /Admin/index");
        }else{
            return header("Location: /Admin/login");
        }
    }

    public function index(){
        $admin = new Admin();
        return $this->twig->render("/Admin/index.html.twig", [
            "clients" => $admin->getAllClients()
        ]);
    }

    public function deleteUser($id){
        $admin = new Admin();
        $delete = $admin->deleteUserById($id);
        if ($delete === true){
            echo "utilisateur supprimé";
        }else{
            echo "impossible à supprimer";
        }
    }
}