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

/* base.html.twig */
class __TwigTemplate_1cb498b9685fc97ccf3c83fc0cc149b9db3bd499978dbd06719ce09fd80bc730 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'css' => [$this, 'block_css'],
            'body' => [$this, 'block_body'],
            'javascript' => [$this, 'block_javascript'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
<html lang=\"fr\">
<head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>";
        // line 7
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    ";
        // line 8
        $this->displayBlock('css', $context, $blocks);
        // line 14
        echo "</head>

<header>
    <section class=\"header-container\">
        <a href=\"#\" ><img id=\"logotype\" src=\"/uploads/marmit_au_thon-05.svg\" />
            <img id=\"logotype2\" src=\"/uploads/marmit_au_thon-02.svg\"/></a>
        <div id=\"search-bar\" class=\"search-bar\" >
            <form id=\"form-header\" method=\"post\">
                <input id=\"form-input-search\" type=\"text\" placeholder=\"Que voulez vous manger ?\">
                <input id=\"form-btn-search\" type=\"submit\" value=\"Rechercher\">
            </form>
        </div>
        <div id=\"separator-vertical\"></div>
        <nav>
            <ul>
                <li><a href=\"#\">Blog</a></li>
                <li><a href=\"#\">Recettes</a></li>
                <li><a href=\"#\">Connexion</a></li>
            </ul>
        </nav>
    </section>
</header>

<body>
";
        // line 38
        $this->displayBlock('body', $context, $blocks);
        // line 39
        $this->displayBlock('javascript', $context, $blocks);
        // line 40
        echo "</body>

<footer>
    <div class=\"footer-container\">
        <section class=\"section1\">
            <h6>Accéder aux pages</h6>
            <hr>
            <ul>
                <li><a href=\"#\">Accueil</a></li>
                <li><a href=\"#\">Toutes les recettes</a></li>
                <li><a href=\"#\">Compte personnel</a></li>
                <li><a href=\"#\">Blog</a></li>
                <li><a href=\"#\">Panier</a></li>
                <li><a href=\"#\">Mentions légales</a></li>
            </ul>
        </section>

        <section class=\"section2\">
            <h6>Suivez-nous</h6>
            <hr>
            <ul>
                <li><a href=\"#\">Facebook</a></li>
                <li><a href=\"#\">Instagram</a></li>
                <li><a href=\"#\">Twitter</a></li>
            </ul>
        </section>

        <section class=\"section3\">
            <h6>Nouveaux articles ? Nouvelles recettes ? <br>Recevez les sur votre boite mail !</h6>
            <form id=\"form-newsletter\" method=\"POST\">
                <input id=\"form-input-mail\" name=\"email\" type=\"email\" placeholder=\"Votre Adresse-email\"/>
                <input id=\"btn-form-newsletter\" type=\"submit\" value=\"S'abonner\"/>
            </form>
        </section>

        <section class=\"section4\">
            <p id=copyright>Copyright - Marmit'au thon - 2021</p>
        </section>

    </div>
</footer>

</html>";
    }

    // line 7
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "Bienvenue sur Marmit'au thon";
    }

    // line 8
    public function block_css($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 9
        echo "        <link rel=\"stylesheet\" href=\"/assets/styles.css\">

        <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\">
        <link href=\"https://fonts.googleapis.com/css2?family=Roboto\" rel=\"stylesheet\">
    ";
    }

    // line 38
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 39
    public function block_javascript($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  156 => 39,  150 => 38,  142 => 9,  138 => 8,  131 => 7,  85 => 40,  83 => 39,  81 => 38,  55 => 14,  53 => 8,  49 => 7,  41 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!doctype html>
<html lang=\"fr\">
<head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>{% block title %}Bienvenue sur Marmit'au thon{% endblock %}</title>
    {% block css %}
        <link rel=\"stylesheet\" href=\"/assets/styles.css\">

        <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\">
        <link href=\"https://fonts.googleapis.com/css2?family=Roboto\" rel=\"stylesheet\">
    {% endblock %}
</head>

<header>
    <section class=\"header-container\">
        <a href=\"#\" ><img id=\"logotype\" src=\"/uploads/marmit_au_thon-05.svg\" />
            <img id=\"logotype2\" src=\"/uploads/marmit_au_thon-02.svg\"/></a>
        <div id=\"search-bar\" class=\"search-bar\" >
            <form id=\"form-header\" method=\"post\">
                <input id=\"form-input-search\" type=\"text\" placeholder=\"Que voulez vous manger ?\">
                <input id=\"form-btn-search\" type=\"submit\" value=\"Rechercher\">
            </form>
        </div>
        <div id=\"separator-vertical\"></div>
        <nav>
            <ul>
                <li><a href=\"#\">Blog</a></li>
                <li><a href=\"#\">Recettes</a></li>
                <li><a href=\"#\">Connexion</a></li>
            </ul>
        </nav>
    </section>
</header>

<body>
{% block body %}{% endblock %}
{% block javascript %}{% endblock %}
</body>

<footer>
    <div class=\"footer-container\">
        <section class=\"section1\">
            <h6>Accéder aux pages</h6>
            <hr>
            <ul>
                <li><a href=\"#\">Accueil</a></li>
                <li><a href=\"#\">Toutes les recettes</a></li>
                <li><a href=\"#\">Compte personnel</a></li>
                <li><a href=\"#\">Blog</a></li>
                <li><a href=\"#\">Panier</a></li>
                <li><a href=\"#\">Mentions légales</a></li>
            </ul>
        </section>

        <section class=\"section2\">
            <h6>Suivez-nous</h6>
            <hr>
            <ul>
                <li><a href=\"#\">Facebook</a></li>
                <li><a href=\"#\">Instagram</a></li>
                <li><a href=\"#\">Twitter</a></li>
            </ul>
        </section>

        <section class=\"section3\">
            <h6>Nouveaux articles ? Nouvelles recettes ? <br>Recevez les sur votre boite mail !</h6>
            <form id=\"form-newsletter\" method=\"POST\">
                <input id=\"form-input-mail\" name=\"email\" type=\"email\" placeholder=\"Votre Adresse-email\"/>
                <input id=\"btn-form-newsletter\" type=\"submit\" value=\"S'abonner\"/>
            </form>
        </section>

        <section class=\"section4\">
            <p id=copyright>Copyright - Marmit'au thon - 2021</p>
        </section>

    </div>
</footer>

</html>", "base.html.twig", "C:\\dev\\www\\Marmit-au-thon\\templates\\base.html.twig");
    }
}
