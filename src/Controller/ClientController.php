<?php


namespace src\Controller;


use src\Model\Client;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ClientController extends AbstractController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * Page d'inscription
     */
    public function register(){
        return $this->twig->render("Client/register.html.twig");
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * Page de connexion
     */
    public function login(){
        return $this->twig->render("Client/login.html.twig");

    }

    /**
     * Déconnecte l'utilisateur et supprime sa session
     */
    public function logout(){
        session_start();
        if (isset($_SESSION)){
            session_destroy();
            header("Location: /");
        }else{
            header("Location: /");
        }
    }

    /**
     *  Insert un utilisateur en base de données
     */
    public function insert(){
        if (empty($_POST)){
            header("Location: /Client/register");
        }else{
            $cliusername = htmlentities($_POST["cliusername"]);
            $climail = htmlentities($_POST["climail"]);
            $clipassword_clear = htmlentities($_POST["clipassword"]);

            //Encodage du mot de passe
            $clipassword_encrypted = password_hash($clipassword_clear,PASSWORD_BCRYPT);

            //Intanciatiion class Client
            $client = new Client();

            try {
                $client->insertClient($cliusername,$climail,$clipassword_encrypted);
                echo "Insertion réussite";
                return null;
            }catch (\Exception $exception){
                echo $exception->getMessage();
                return null;
            }
        }
    }

    public function connectClient(){
        if (empty($_POST)){
            header("Location: /Client/login");
        }
        else{
            $climail = htmlentities($_POST["climail"]);
            $clipassword_clear = htmlentities($_POST["clipassword"]);
            $client = new Client();
            //Décodage du mot de passe
            $clipassword_encrypted = $client->getClientPassword($climail);

            $checkPassword = password_verify($clipassword_clear,$clipassword_encrypted);
            if ($checkPassword){
                session_start();
                $getClient = $client->getClientByEmail($climail);
                $_SESSION["client"] = [
                    "idclient" => $getClient["idclient"],
                    "cliusername" => $getClient["cliusername"],
                    "climail" => $getClient["climail"],
                    "cliadmin" => $getClient["cliadmin"]
                ];
                return header("Location: /");
            }else{
                echo "Mauvais mot de passe";
            }
        }
    }
}