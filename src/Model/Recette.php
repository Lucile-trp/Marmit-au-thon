<?php
namespace src\Model;

use PDO;
use PDOException;
use Cocur\Slugify\Slugify;

class Recette{
    private $idrecipe;
    private $recname;
    private $recnameslug;
    private $recimg;
    private $recidclient;
    private $rechowmany;
    private $rectext;

    /**
     * @return mixed
     */
    public function getIdrecipe()
    {
        return $this->idrecipe;
    }

    /**
     * @param mixed $idrecipe
     */
    public function setIdrecipe($idrecipe): void
    {
        $this->idrecipe = $idrecipe;
    }

    /**
     * @return mixed
     */
    public function getRecname()
    {
        return $this->recname;
    }

    /**
     * @param mixed $recname
     */
    public function setRecname($recname): void
    {
        $this->recname = $recname;
    }

    /**
     * @return mixed
     */
    public function getRecnameslug()
    {
        return $this->recnameslug;
    }

    /**
     * @param mixed $recnameslug
     */
    public function setRecnameslug($recnameslug): void
    {
        $this->recnameslug = $recnameslug;
    }

    /**
     * @return mixed
     */
    public function getRecimg()
    {
        return $this->recimg;
    }

    /**
     * @param mixed $recimg
     */
    public function setRecimg($recimg): void
    {
        $this->recimg = $recimg;
    }

    /**
     * @return mixed
     */
    public function getRecidclient()
    {
        return $this->recidclient;
    }

    /**
     * @param mixed $recidclient
     */
    public function setRecidclient($recidclient): void
    {
        $this->recidclient = $recidclient;
    }

    /**
     * @return mixed
     */
    public function getRechowmany()
    {
        return $this->rechowmany;
    }

    /**
     * @param mixed $rechowmany
     */
    public function setRechowmany($rechowmany): void
    {
        $this->rechowmany = $rechowmany;
    }

    /**
     * @return mixed
     */
    public function getRectext()
    {
        return $this->rectext;
    }

    /**
     * @param mixed $rectext
     */
    public function setRectext($rectext): void
    {
        $this->rectext = $rectext;
    }


    /**
     * @param PDO $bdd
     * @param Int $id
     * @return array
     */
    public function getRecipeFromId(PDO $bdd, Int $id){
        $query = "SELECT r.recname, r.recnameslug, ingname, joinquantite, uniname 
                    FROM recipe r
                    INNER JOIN joinrecing jri ON jri.joinidrecipe = r.idrecipe
                    INNER JOIN ingredient i ON jri.joinidingredient = i.idingredient
                    INNER JOIN unity u ON jri.joinidunite = u.idunity
                    WHERE idrecipe = :id";

        $stmt = $bdd->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e){
            echo $e->getMessage();
        }

    }

    public function getIngredient(PDO $bdd, Int $id){
        $query = "SELECT ingname, joinquantite, uniname FROM ingredient INNER JOIN joinrecing
                    ON idingredient=joinidingredient INNER JOIN unity
                    ON joinidunite=idunity INNER JOIN recipe
                    ON  joinidrecipe=1 = :id";

        $stmt = $bdd->prepare($query);
        $stmt->bindValue(
            ":id", $this->getIdrecipe(), PDO::PARAM_INT);

        try {
            $stmt->execute();
        }catch (Exception $e){
            echo $e->getMessage();
        }
    return $stmt->fetchAll();
    }

    /**
     * @param $recipename
     * @param $recipeImage
     * @param $howmany
     * @param $iddiet
     * @param array $ingredients
     * @param array $quantity
     * @param array $units
     * @param $recipestep
     * @return string
     * Insert une recette compl??te en base donn??es
     */
    public function insertRecipe($recipename,$recipeImage,$howmany,$iddiet,array $ingredients,array $quantity,array $units,$recipestep){
        //Insertion de la recette dans la table recipe
        $requete1 = BDD::getInstance()->prepare("INSERT INTO recipe (recname, recnameslug, recimg, rechowmany, rectext)
                                                 VALUES(:recname, :recnameslug, :recimg ,:rechowmany, :recipestep)");
        // Insertion de l'iddiet et idrecipe dans la table joinrecdiet
        $requete2 = BDD::getInstance()->prepare("INSERT INTO joinrecdiet(joinidrecipe,joiniddiet)
                                                 VALUES((SELECT idrecipe FROM marmitothon_bdd.recipe ORDER BY idrecipe DESC LIMIT 1), :iddiet)");
        // Insertion des ingredients dans la table ingredient et insertions dans la table joinrecing
        $insertionIngredient = BDD::getInstance()->prepare("INSERT INTO ingredient(ingname) VALUES(:ingredientName)");

        try {
            $slug = new Slugify();
            $requete1->execute([
                "recname" => $recipename,
                "recnameslug" => $slug->slugify($recipename),
                "recimg" => $recipeImage,
                "rechowmany" => $howmany,
                "recipestep" => $recipestep
            ]);
            $requete2->execute([
                "iddiet" => $iddiet
            ]);
        }catch (PDOException $exception){
            return $exception->getMessage();
        }

        foreach ($ingredients as $index => $ingredient){
            $idIngredient = $this->checkIngredient($ingredient[$index]);
            if (is_null($idIngredient)){
                $insertionJoinRecIng = BDD::getInstance()->prepare("INSERT INTO joinrecing(joinidrecipe,joinidingredient,joinquantite,joinidunite)
                                                            VALUES ((SELECT idrecipe FROM marmitothon_bdd.recipe ORDER BY idrecipe DESC LIMIT 1),
                                                                   (SELECT idingredient FROM marmitothon_bdd.ingredient ORDER BY idingredient DESC LIMIT 1),
                                                                   :ingredientQuantity,
                                                                   (SElECT idunity FROM unity WHERE uniname = :uniname))");
            }
            else{
                $insertionJoinRecIng = BDD::getInstance()->prepare("INSERT INTO joinrecing(joinidrecipe,joinidingredient,joinquantite,joinidunite)
                                                            VALUES ((SELECT idrecipe FROM marmitothon_bdd.recipe ORDER BY idrecipe DESC LIMIT 1),
                                                                   :idIngredient,
                                                                   :ingredientQuantity,
                                                                   (SElECT idunity FROM unity WHERE uniname = :uniname))");
            }
            $ingredientName = $ingredient;
            $ingredientQuantity = $quantity[$index];
            $ingredientUnity = $units[$index];
            try {
                $insertionIngredient->execute([
                    "ingredientName" => $ingredientName
                ]);
                if (is_null($idIngredient)){
                    $insertionJoinRecIng->execute([
                        "ingredientQuantity" => $ingredientQuantity,
                        "uniname" => $ingredientUnity
                    ]);
                }else{
                    $insertionJoinRecIng->execute([
                        "idIngredient" => $idIngredient,
                        "ingredientQuantity" => $ingredientQuantity,
                        "uniname" => $ingredientUnity
                    ]);
                }
            }catch (PDOException $exception){
                return $exception->getMessage();
            }
        }
    }

    public function checkIngredient($ingredient){
        $requete = BDD::getInstance()->prepare("SELECT idingredient FROM ingredient WHERE ingname = :ingredientName ORDER BY idingredient DESC LIMIT 1");
        $requete->execute([
            "ingredientName" => $ingredient
        ]);
        $idIngredient = $requete->fetchColumn();
        if ($idIngredient == false){
            return $idIngredient = null;
        }else{
            return $idIngredient;
        }
    }

    /**
     * @param $slug
     * @return string
     * R??cup??re une recette compl??te par rapport ?? son slug
     */
    public function getRecipeBySlug($slug){
        $query = BDD::getInstance()->prepare("
            SELECT 	r.idrecipe,
                    r.recname,
                    r.recnameslug,
                    r.recimg,
                    r.recidclient,
                    r.rechowmany,
                    r.rectext,
                    i.ingname,
                   jri.joinquantite,
                    u.uniname
            FROM recipe r
            INNER JOIN joinrecdiet jrd ON r.idrecipe = jrd.joinidrecipe
            INNER JOIN diet d ON jrd.joiniddiet = d.iddiet
            INNER JOIN joinrecing jri ON jri.joinidrecipe = r.idrecipe
            INNER JOIN ingredient i ON jri.joinidingredient = i.idingredient
            INNER JOIN unity u ON jri.joinidunite = u.idunity
            WHERE recnameslug = :recnameslug");
        try {
            $query->execute([
                "recnameslug" => $slug
            ]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
    }

    /**
     * @param $id
     * @return string
     * R??cup??rer le slug d'une recette en fonction de son id
     */
    public function getRecipeSlug($id){
        $query = BDD::getInstance()->prepare("SELECT recnameslug FROM recipe WHERE idrecipe = :id LIMIT 1");
        try {
            $query->execute([
                "id" => $id
            ]);
            return $query->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Affiche le nombre de recette donn?? en param??tre sur la page de listing
     */
    public function getRecipes(){
        $query = BDD::getInstance()->prepare("
            SELECT DISTINCT r.idrecipe,
                            r.recname,
                            r.recnameslug,
                            r.recimg,
                            r.recidclient,
                            r.rechowmany,
                            d.dietname
            FROM recipe r
            INNER JOIN joinrecdiet jrd ON r.idrecipe = jrd.joinidrecipe
            INNER JOIN diet d ON jrd.joiniddiet = d.iddiet
            INNER JOIN joinrecing jri ON jri.joinidrecipe = r.idrecipe
            INNER JOIN ingredient i ON jri.joinidingredient = i.idingredient
            INNER JOIN unity u ON jri.joinidunite = u.idunity
            ORDER BY idrecipe DESC");
        try {
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
    }

    /**
     * @param $idrecipe
     * @return string
     * R??cup??re une recette compl??te par rapport ?? son ID
     */
    public function getRecipeByIdRecipe($idrecipe){
        $query = BDD::getInstance()->prepare("
            SELECT 	r.idrecipe,
                    r.recname,
                    r.recnameslug,
                    r.recimg,
                    r.recidclient,
                    r.rechowmany,
                    r.rectext,
                    i.ingname,
                    jri.joinquantite,
                    u.uniname
            FROM recipe r
            INNER JOIN joinrecdiet jrd ON r.idrecipe = jrd.joinidrecipe
            INNER JOIN diet d ON jrd.joiniddiet = d.iddiet
            INNER JOIN joinrecing jri ON jri.joinidrecipe = r.idrecipe
            INNER JOIN ingredient i ON jri.joinidingredient = i.idingredient
            INNER JOIN unity u ON jri.joinidunite = u.idunity
            WHERE idrecipe = :idrecipe");

        try {
            $query->bindParam(':idrecipe', $idrecipe, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
    }

    /**
     * @return string
     * R??cup??re toutes les recettes
     */
    public function getAllRecipes(){
        $query = BDD::getInstance()->prepare("            
            SELECT DISTINCT r.idrecipe,
                            r.recname,
                            r.recnameslug,
                            r.recimg,
                            r.recidclient,
                            r.rechowmany,
                            d.dietname
            FROM recipe r
            INNER JOIN joinrecdiet jrd ON r.idrecipe = jrd.joinidrecipe
            INNER JOIN diet d ON jrd.joiniddiet = d.iddiet
            INNER JOIN joinrecing jri ON jri.joinidrecipe = r.idrecipe
            INNER JOIN ingredient i ON jri.joinidingredient = i.idingredient
            INNER JOIN unity u ON jri.joinidunite = u.idunity
            ORDER BY idrecipe DESC");

        try {
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
    }

    /**
     * @param $id
     * @return string
     * Supprime une recette par rapport ?? son ID
     */
    public function deleteRecipe($id){
        $query = BDD::getInstance()->prepare("DELETE FROM recipe WHERE idrecipe = :id");
        try {
            $query->bindParam(":id", $id, PDO::PARAM_INT);
            $query->execute();
            return true;
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
    }
}