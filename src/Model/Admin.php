<?php

namespace src\Model;

use PDO;

class Admin
{
    private $idclient;
    private $cliusername;
    private $climail;
    private $clipassword;
    private $cliadmin;

    /**
     * @return mixed
     */
    public function getIdclient()
    {
        return $this->idclient;
    }

    /**
     * @param mixed $idclient
     * @return Admin
     */
    public function setIdclient($idclient)
    {
        $this->idclient = $idclient;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCliusername()
    {
        return $this->cliusername;
    }

    /**
     * @param mixed $cliusername
     * @return Admin
     */
    public function setCliusername($cliusername)
    {
        $this->cliusername = $cliusername;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClimail()
    {
        return $this->climail;
    }

    /**
     * @param mixed $climail
     * @return Admin
     */
    public function setClimail($climail)
    {
        $this->climail = $climail;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClipassword()
    {
        return $this->clipassword;
    }

    /**
     * @param mixed $clipassword
     * @return Admin
     */
    public function setClipassword($clipassword)
    {
        $this->clipassword = $clipassword;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCliadmin()
    {
        return $this->cliadmin;
    }

    /**
     * @param mixed $cliadmin
     * @return Admin
     */
    public function setCliadmin($cliadmin)
    {
        $this->cliadmin = $cliadmin;
        return $this;
    }

    /**
     * @param $climail
     * @return mixed|string
     * Vérifie sur l'utilisateur à la rôle admin
     */
    public function isAdmin($climail){
        $query = BDD::getInstance()->prepare("SELECT climail from client where cliadmin = 1 AND climail = :climail");

        try {
            $query->bindParam(':climail', $climail, PDO::PARAM_INT);

            return $query->execute();
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
    }

    /**
     * @param $climail
     * @return string
     * Retourne un tableau associatif d'un compte admin
     */
    public function getAdminAccount($climail){
        $query = BDD::getInstance()->prepare("SELECT climail, clipassword FROM client WHERE climail = :climail AND cliadmin = 1");
        try {
            $query->bindParam(':climail', $climail, PDO::PARAM_STR);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
    }

    /**
     * @return mixed|string
     * Retourne tous les clients présent en base de données
     */
    public function getAllClients(){
        $query = BDD::getInstance()->prepare("SELECT idclient, cliusername, climail FROM client WHERE cliadmin = 0");

        try {
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
    }

    public function deleteUserById($id){
        $query = BDD::getInstance()->prepare("DELETE FROM client WHERE idclient = :id");

        try {
            $query->bindParam(":id",$id,PDO::PARAM_INT);
            return $query->execute();
        }catch (\PDOException $exception){
            return $exception->getMessage();
        }
    }
}