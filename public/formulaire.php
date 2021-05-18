<?php
use src\Model\BDD;
$hostname = "mysql-marmitothon.alwaysdata.net";
$username = "230409";
$password = "marmitothon-cubes";
$dbname = "marmitothon_bdd";
$bdd= new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
 //var_dump($_GET);
?>


<?php
if(isset($_POST['combien'])){
    $combien=$_POST['combien'];

    //HTML Form Add recipe
    //return $this->twig->render("admin/addRecette2.html.twig");
?>

<form name="article" method="post" action="http://www.marmitothon.local/?controller=Ingredient&action=new" enctype="multipart/form-data">
    <input type="text" name="recname" placeholder="Nom de la recette" required>
    <select name="diet" size="1" required>
        <option selected>Régime alimentaire
    <?php
    $query=$bdd->prepare("SELECT dietname FROM diet");
    $query->execute();
    $datas = $query->fetchAll();
    for($i=0;$i<=count($datas)-1;$i++){
        $diet=$datas[$i]['dietname'];
        echo"<option> $diet" ;
    }
    ?>
    </select><br>
    <select name="rechowmany" size="1">
        <option>1 personne
        <option>2 personnes
        <option>4 personnes
        <option>6 personnes
        <option>8 personnes
    </select><br>
<?php
    for ($j=0;$j<=$combien;$j++){
        echo"<input type=\"text\" name=\"ingredient$j\" placeholder=\"Ingrédient $j\">
            <input type=\"text\" name=\"quantite\" placeholder=\"Quantité\">";
        $requete=$bdd->prepare("SELECT uniname FROM unity");
        $requete->execute();
        $datas = $requete->fetchAll();
        //var_dump($datas);
?>
    <select name="unity" size="1">
        <option>Unité
<?php

    for($i=0;$i<=count($datas)-1;$i++){
        $unity=$datas[$i]['uniname'];
        echo"<option> $unity" ;
    }
?>
    </select><br>
<?php
    }
?>
    <textarea name="textarea"
              rows="10" cols="50">Votre recette.</textarea>
    <input type="file" name="recimg">
    <input type="submit" value="Ajouter cette recette">
</form>
<?php
}else{
    echo "Choississez un nombre d'ingrédients";
}

?>
</body>
</html>





