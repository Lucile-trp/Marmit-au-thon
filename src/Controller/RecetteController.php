<?php
namespace src\Controller;

use src\Controller\AbstractController;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class RecetteController extends AbstractController {
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(){
        return $this->twig->render("Recette/index.html.twig");
    }
}