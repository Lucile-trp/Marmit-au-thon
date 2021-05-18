<?php
namespace src\Model;
use PDO;

class Ingredient{
    private $idingredient;
    private $ingname;

    //GETTERS & SETTERS
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

    //REQUETES BDD

    //RECUPERER tous les ingrédients
    public function getAllIngredient(\PDO $bdd, Int $id)
    {
        $requete = BDD::getInstance()->prepare("SELECT * FROM ingredient");
        $requete->execute();
        return $requete->fetchAll(\PDO::FETCH_CLASS, "src\Model\Ingredient");
    }

    //RECUPERER ingrédients par recherche
    public function getIngredientBySearch(\PDO $bdd, $search){
        $query = "SELECT idingredient, ingname FROM ingredient WHERE ingname LIKE '%:search%'";

        $stmt = $bdd->prepare($query);

        try {
            $stmt->execute([
                ":search=>$search"
            ]);
        }catch (Exception $e){
            echo $e->getMessage();
        }
        $ingredient=$stmt->fetchAll(PDO::FETCH_CLASS, "src\Model\Ingredient");
        return $ingredient;

    }


}
