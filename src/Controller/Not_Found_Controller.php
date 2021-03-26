<?php
namespace src\Controller;


class Not_Found_Controller extends Abstract_Controller{

    public function index(){
        return $this->twig->render("Not_Found/index.html.twig");
    }

}