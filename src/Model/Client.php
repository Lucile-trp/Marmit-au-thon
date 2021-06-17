<?php


namespace src\Model;

use PDO;

class Client
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
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * @return Client
     */
    public function setCliadmin($cliadmin)
    {
        $this->cliadmin = $cliadmin;
        return $this;
    }

    /**
     * @param $climail
     * @return string
     * Récupère un client par rapport à son email
     */
    public function getClientByEmail($climail){
        $query = BDD::getInstance()->prepare("SELECT idclient,cliusername,climail,cliadmin FROM client WHERE climail = :climail");

        try {
            $query->bindParam(':climail', $climail, PDO::PARAM_STR);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
    }

    /**
     * @param $cliusername
     * @param $climail
     * @param $clipassword
     * @param int $cliadmin
     * @return bool
     * Insert un nouvel utilisateur en base de données
     */
    public function insertClient($cliusername,$climail,$clipassword,$cliadmin = 0){
        $query = BDD::getInstance()->prepare("INSERT INTO client(cliusername,climail,clipassword,cliadmin)
                                              VALUES(:cliusername,:climail,:clipassword,:cliadmin)");

        try {
            $query->bindParam(':cliusername', $cliusername, PDO::PARAM_STR);
            $query->bindParam(':climail', $climail, PDO::PARAM_STR);
            $query->bindParam(':clipassword', $clipassword, PDO::PARAM_STR);
            $query->bindParam(':cliadmin', $cliadmin, PDO::PARAM_INT);
            $query->execute();
            return true;
        }catch (PDOException $exception){
            echo $exception->getMessage();
            return false;
        }
    }

    /**
     * @param $climail
     * @return false
     */
    public function getClientPassword($climail){
        $query = BDD::getInstance()->prepare("SELECT clipassword FROM client WHERE climail = :climail");

        try {
            $query->bindParam(':climail', $climail, PDO::PARAM_STR);
            $query->execute();
            return $query->fetchColumn();
        }catch (PDOException $exception){
            echo $exception->getMessage();
            return false;
        }
    }
}