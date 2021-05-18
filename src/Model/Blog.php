<?php

namespace src\Model;
use src\Model\BDD;
use PDO;

class Blog {
    private $id;
    private $title;
    private $content;
    private $date;
    private $slug;
    private $cli_id;

    public function getAll(){
        $bdd = BDD::getInstance();
        $request = "SELECT * FROM article;";

        $req = $bdd->prepare($request);
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    public static function getOne($id){
        $bdd = BDD::getInstance();
        $request = "SELECT * FROM article WHERE art_id=:id;";

        $req = $bdd->prepare($request);
        $req->bindParam(':id', $id);
        $req->execute();
        $result = $req->fetch();
        return $result;

    }

}