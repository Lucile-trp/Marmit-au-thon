<?php
namespace src\Model;
use PDO;

class Unity{
    private $idunity;
    private $unityname;

    //GETTERS & SETTERS
    /**
     * @return mixed
     */
    public function getIdUnity()
    {
        return $this->idunity;
    }

    /**
     * @param mixed $idunity
     */
    public function setIdUnity($idunity): void
    {
        $this->idunity = $idunity;
    }

    /**
     * @return mixed
     */
    public function getUnityName()
    {
        return $this->unityname;
    }

    /**
     * @param mixed $unityname
     */
    public function setUnityName($unityname): void
    {
        $this->unityname = $unityname;
    }

    //REQUETES BDD

    //RECUPERER toutes les unités
    public function getAllUnity()
    {
        $requete = BDD::getInstance()->prepare("SELECT * FROM unity");
        $requete->execute();
        return $requete->fetchAll(\PDO::FETCH_CLASS, "src\Model\Unity");
    }

    //RECUPERER régime par recherche
    /*public function getunityBySearch(\PDO $bdd, $search){
        $query = "SELECT idunity, unityname FROM unity WHERE unity.unityname LIKE '%:search%'";

        $stmt = $bdd->prepare($query);

        try {
            $stmt->execute([
                ":search=>$search"
            ]);
        }catch (Exception $e){
            echo $e->getMessage();
        }
        $unity=$stmt->fetchAll(PDO::FETCH_CLASS, "src\Model\unity");
        return $unity;

    }*/


}
