<?php


namespace src\Controller;


use src\Model\Admin;
use src\Model\Client;
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
        var_dump($_POST);
        die();
        $mail = htmlentities($_POST["climail"]);
        $password_clear = htmlentities($_POST["password"]);

        $admin = new Admin();
        $password_encrypted = $admin->getAdminAccount($mail)["password"];

        $checkPassword = password_verify($password_clear,$password_encrypted);

        $isAdmin = $admin->isAdmin($mail);

        if (is_null($isAdmin) && $checkPassword === false){
            return headers("Location: /");
        }else{
            return $this->twig->render("/Admin/index.html.twig", [
                "clients" => $admin->getAllClients()
            ]);
        }
    }
}