<?php
namespace src\Model;

use PDO;
use PDOException;

class Recette{
    //private $idrecipe;
    private $recname;
    private $recimg;
    private $recidclient;
    private $rechowmany;

    //private $joinidrecipe;
    //private $joiniddiet;

    //private $iddiet;
    private $dietname;

    //private $idingredient;
    private $ingname;

    //private $joinidingredient;
    private $joinquantite;
    //private $joinidunity;

    //private $idunity;
    private $uniname;

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
    public function setIdrecipe($idrecipe)
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
    public function setRecname($recname)
    {
        $this->recname = $recname;
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
    public function setRecimg($recimg)
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
    public function setRecidclient($recidclient)
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
    public function setRechowmany($rechowmany)
    {
        $this->rechowmany = $rechowmany;
    }

    public function addRecipe(){
        
    }

    /**
     * @return mixed
     */
    public function getJoinidrecipe()
    {
        return $this->joinidrecipe;
    }

    /**
     * @param mixed $joinidrecipe
     */
    public function setJoinidrecipe($joinidrecipe): void
    {
        $this->joinidrecipe = $joinidrecipe;
    }

    /**
     * @return mixed
     */
    public function getJoiniddiet()
    {
        return $this->joiniddiet;
    }

    /**
     * @param mixed $joiniddiet
     */
    public function setJoiniddiet($joiniddiet): void
    {
        $this->joiniddiet = $joiniddiet;
    }

    /**
     * @return mixed
     */
    public function getIddiet()
    {
        return $this->iddiet;
    }

    /**
     * @param mixed $iddiet
     */
    public function setIddiet($iddiet): void
    {
        $this->iddiet = $iddiet;
    }

    /**
     * @return mixed
     */
    public function getDietname()
    {
        return $this->dietname;
    }

    /**
     * @param mixed $dietname
     */
    public function setDietname($dietname): void
    {
        $this->dietname = $dietname;
    }

    /**
     * @return mixed
     */
    public function getIdingredient()
    {
        return $this->idingredient;
    }

    /**
     * @param mixed $idingredient
     */
    public function setIdingredient($idingredient): void
    {
        $this->idingredient = $idingredient;
    }

    /**
     * @return mixed
     */
    public function getIngname()
    {
        return $this->ingname;
    }

    /**
     * @param mixed $ingname
     */
    public function setIngname($ingname): void
    {
        $this->ingname = $ingname;
    }

    /**
     * @return mixed
     */
    public function getJoinidingredient()
    {
        return $this->joinidingredient;
    }

    /**
     * @param mixed $joinidingredient
     */
    public function setJoinidingredient($joinidingredient): void
    {
        $this->joinidingredient = $joinidingredient;
    }

    /**
     * @return mixed
     */
    public function getJoinquantite()
    {
        return $this->joinquantite;
    }

    /**
     * @param mixed $joinquantite
     */
    public function setJoinquantite($joinquantite): void
    {
        $this->joinquantite = $joinquantite;
    }

    /**
     * @return mixed
     */
    public function getJoinidunity()
    {
        return $this->joinidunity;
    }

    /**
     * @param mixed $joinidunity
     */
    public function setJoinidunity($joinidunity): void
    {
        $this->joinidunity = $joinidunity;
    }

    /**
     * @return mixed
     */
    public function getIdunity()
    {
        return $this->idunity;
    }

    /**
     * @param mixed $idunity
     */
    public function setIdunity($idunity): void
    {
        $this->idunity = $idunity;
    }

    /**
     * @return mixed
     */
    public function getUniname()
    {
        return $this->uniname;
    }

    /**
     * @param mixed $uniname
     */
    public function setUniname($uniname): void
    {
        $this->uniname = $uniname;
    }


    /**
     * @param PDO $bdd
     * @param Int $id
     */
    public function getRecipeFromId(PDO $bdd, Int $id){
        $query = "SELECT * FROM recipe WHERE idrecipe = :id";

        $stmt = $bdd->prepare($query);
        $stmt->bindValue(":id", $this->getIdrecipe(), PDO::PARAM_INT);

        try {
            $stmt->execute();
        }catch (Exception $e){
            echo $e->getMessage();
        }

    }
    //RECUPERER tous les ingrédients de la recette via son id
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

//CREER nouvelle recette
    public function AddNewRecipe($recname,$recimg,$dietname,$howmany,$ingredient,$quantite,$unity,$recette){
        //$client="";
        try{
            // INSERT DATABASE RECIPE
            $queryRecipe=BDD::getInstance()->prepare("INSERT INTO recipe (recname, recimg, recidclient, rechowmany)
                VALUES(:recname, :recimg, :recidclient, :rechowmany)");
            $execute = $queryRecipe->execute([
                "recname" => $recname,
                "recimg" => $recimg,
                "recidclient" => $_SESSION['id'],
                "rechowmany" =>$howmany
            ]);

            // FIND ID DIET
            $queryRecipe=BDD::getInstance()->prepare("SELECT iddiet FROM diet WHERE dietname=:dietname");
            $execute = $queryRecipe->execute([
                "dietname" => $dietname
            ]);

            // INSERT DATABASE JOINRECDIET
            $queryRecipe=BDD::getInstance()->prepare("INSERT INTO joinrecdiet (joinidrecipe, joiniddiet)
                VALUES(:idrecipe, :iddiet)");
            $execute = $queryRecipe->execute([
                "idrecipe" => $idrecipe,
                "iddiet" => $iddiet,
                "recidclient" => $_SESSION['id'],
                "rechowmany" =>$howmany
            ]);
            return "OK";
        }
        catch (\Exception $e){
            return $e->getMessage();
        }

    }

    public function insertRecipe($recipename,$recipeImage,$howmany,$iddiet,array $ingredients,array $quantity,array $units,$recipestep){
        //Insertion de la recette dans la table recipe
        $requete1 = BDD::getInstance()->prepare("INSERT INTO recipe (recname, recimg,rechowmany, rectext)
                                                 VALUES(:recname, :recimg ,:rechowmany, :recipestep)");
        try {
            $requete1->execute([
                "recname" => $recipename,
                "recimg" => $recipeImage,
                "rechowmany" => $howmany,
                "recipestep" => $recipestep
            ]);
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
        // Insertion de l'iddiet et idrecipe dans la table joinrecdiet
        $requete2 = BDD::getInstance()->prepare("INSERT INTO joinrecdiet(joinidrecipe,joiniddiet)
                                                 VALUES((SELECT idrecipe FROM marmitothon_bdd.recipe ORDER BY idrecipe DESC LIMIT 1), :iddiet)");
        try {
            $requete2->execute([
                "iddiet" => $iddiet
            ]);
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
        // Insertion des ingredients dans la table ingredient et insertions dans la table joinrecing
        $insertionIngredient = BDD::getInstance()->prepare("INSERT INTO ingredient(ingname) VALUES(:ingredientName)");
        // Si l'ingredient existe, récupérer l'id s'il n'existe pas, insérer l'ingredient
        foreach ($ingredients as $index => $ingredient){
            $idIngredient = $this->checkIngredient($ingredient[$index]);
            var_dump($idIngredient);
            if (is_null($idIngredient)){
                $insertionJoinRecIng = BDD::getInstance()->prepare("INSERT INTO joinrecing(joinidrecipe,joinidingredient,joinquantite,joinidunite)
                                                            VALUES ((SELECT idrecipe FROM marmitothon_bdd.recipe ORDER BY idrecipe DESC LIMIT 1),
                                                                   (SELECT idingredient FROM marmitothon_bdd.ingredient ORDER BY idingredient DESC LIMIT 1),
                                                                   :ingredientQuantity,
                                                                   :ingredientUnity)");
            }
            else{
                $insertionJoinRecIng = BDD::getInstance()->prepare("INSERT INTO joinrecing(joinidrecipe,joinidingredient,joinquantite,joinidunite)
                                                            VALUES ((SELECT idrecipe FROM marmitothon_bdd.recipe ORDER BY idrecipe DESC LIMIT 1),
                                                                   :idIngredient,
                                                                   :ingredientQuantity,
                                                                   :ingredientUnity)");
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
                        "ingredientUnity" => $ingredientUnity
                    ]);
                }else{
                    $insertionJoinRecIng->execute([
                        "idIngredient" => $idIngredient,
                        "ingredientQuantity" => $ingredientQuantity,
                        "ingredientUnity" => $ingredientUnity
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

    public function getRecipe(){
        $query = BDD::getInstance()->prepare("SELECT * FROM recipe WHERE recimg IS NOT NULL");
        try {
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
    }

}