<?php
namespace src\Controller;

class HomeController extends AbstractController
{
    public function index(){
        return $this->twig->render("home/index.html.twig");
    }
}