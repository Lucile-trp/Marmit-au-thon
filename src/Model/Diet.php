<?php
namespace src\Model;
use PDO;

class Diet{
    private $iddiet;
    private $dietname;

    //GETTERS & SETTERS
    /**
     * @return mixed
     */
    public function getIdDiet()
    {
        return $this->iddiet;
    }

    /**
     * @param mixed $iddiet
     */
    public function setIdDiet($iddiet): void
    {
        $this->iddiet = $iddiet;
    }

    /**
     * @return mixed
     */
    public function getDietName()
    {
        return $this->dietname;
    }

    /**
     * @param mixed $dietname
     */
    public function setDietName($dietname): void
    {
        $this->dietname = $dietname;
    }

    //REQUETES BDD

    //RECUPERER tous les régimes
    public function getAllDiet()
    {
        $requete = BDD::getInstance()->prepare("SELECT * FROM diet");
        $requete->execute();
        return $requete->fetchAll(\PDO::FETCH_CLASS, "src\Model\Diet");
    }

        //RECUPERER régime par recherche
        /*public function getDietBySearch(\PDO $bdd, $search){
            $query = "SELECT iddiet, dietname FROM diet WHERE diet.dietname LIKE '%:search%'";

            $stmt = $bdd->prepare($query);

            try {
                $stmt->execute([
                    ":search=>$search"
                ]);
            }catch (Exception $e){
                echo $e->getMessage();
            }
            $diet=$stmt->fetchAll(PDO::FETCH_CLASS, "src\Model\Diet");
            return $diet;

        }*/


    }
