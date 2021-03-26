<?php
namespace src\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController {
    protected $loader;
    protected $twig;

    public function getTwig(){
        return $this->twig;
    }

    public function __construct(){
        $this->loader = new FilesystemLoader($_SERVER["DOCUMENT_ROOT"]."/../templates");
        $this->twig = new Environment($this->loader,[
            "debug" => true,
            "cache" => $_SERVER["DOCUMENT_ROOT"]."/../var/cache"
        ]);
        $this->twig->addExtension(new DebugExtension());
    }

}