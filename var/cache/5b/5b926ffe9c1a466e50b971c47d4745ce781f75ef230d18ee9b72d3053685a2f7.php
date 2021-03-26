<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* Not_Found/index.html.twig */
class __TwigTemplate_5e422063491d48861333b582220510be14e85e2f251b1de5f62bcb0b69745688 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.html.twig", "Not_Found/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "404 - Not Found !";
    }

    // line 3
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "    <h1>Hop Hop Hop il y a rien à voir ici !</h1>
    <img src=\"https://media1.tenor.com/images/0b1b9d86030586786a5a37655258b393/tenor.gif\" alt=\"gif de chat qui pleure\" height=\"600\" width=\"800\">
    <a href=\"/\">Retourner à l'accueil du site.</a>
";
    }

    public function getTemplateName()
    {
        return "Not_Found/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 4,  54 => 3,  47 => 2,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}
{% block title '404 - Not Found !' %}
{% block body %}
    <h1>Hop Hop Hop il y a rien à voir ici !</h1>
    <img src=\"https://media1.tenor.com/images/0b1b9d86030586786a5a37655258b393/tenor.gif\" alt=\"gif de chat qui pleure\" height=\"600\" width=\"800\">
    <a href=\"/\">Retourner à l'accueil du site.</a>
{% endblock %}", "Not_Found/index.html.twig", "C:\\dev\\www\\Marmit-au-thon\\templates\\Not_Found\\index.html.twig");
    }
}
