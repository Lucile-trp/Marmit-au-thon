<?php
namespace src\Controller;


class NotFoundController extends AbstractController{

    public function index(){
        return $this->twig->render("Not_Found/index.html.twig");
    }

}