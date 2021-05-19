<?php

namespace src\Model;
use src\Model\BDD;
use PDO;
use Cocur\Slugify\Slugify;

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



    public function insertArticle($datas){


        $title = $datas['art-title'];
        $resume = $datas['art-resume'];
        $content = $datas['art-content'];

        $slugify = new Slugify();
        $slug = $slugify->slugify($title);

        $cli_id = 1;

        $bdd = BDD::getInstance();
        $request = "INSERT INTO article(art_title, art_resume, art_content, art_slug, cli_id) VALUES (:title, :resume, :content, :slug, :cli_id);";
        try {
            $req = $bdd->prepare($request);
            $req->bindParam(':title', $title);
            $req->bindParam(':resume', $resume);
            $req->bindParam(':content', $content);
            $req->bindParam(':slug', $slug);
            $req->bindParam(':cli_id', $cli_id);
            $req->execute();


    } catch(\PDOException $exception) {
            echo $exception->getMessage();

    }

    }

}