<?php
namespace src\Controller;

class BlogController extends AbstractController
{
    public function index(){
        return $this->twig->render("Blog/blog.html.twig");
    }
}