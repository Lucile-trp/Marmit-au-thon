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
        $request = "SELECT * FROM article ORDER BY art_id DESC ;";

        $req = $bdd->prepare($request);
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }
    public function getThree(){
        $bdd = BDD::getInstance();
        $request = "SELECT * FROM article ORDER BY art_id DESC LIMIT 3;";

        $req = $bdd->prepare($request);
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    public static function getOne($slug){
        $bdd = BDD::getInstance();
        $request = "SELECT * FROM article WHERE art_slug=:slug;";

        $req = $bdd->prepare($request);
        $req->bindParam(':slug', $slug);
        $req->execute();
        $result = $req->fetch();
        return $result;
    }



    public function insertArticle($datas, $img){
        $title = $datas['art-title'];
        $resume = $datas['art-resume'];
        $content = $datas['art-content'];

        $slugify = new Slugify();
        $slug = $slugify->slugify($title);

        $cli_id = 1;

        if (!empty($datas && $img)) {
            // Gestion de l'image de l'article
            $tabExt = ['jpg', 'png', 'jpeg', 'JPG', 'JPEG', 'PNG']; // extensions acceptées
            $extension = pathinfo($img['article-img']['name'], PATHINFO_EXTENSION);
            if (in_array(strtolower($extension), $tabExt)) {
                $artImageName = md5(uniqid()) . '.' . $extension;
                $dateNow = new \DateTime();
                $imageFolder = "./uploads/article-images/" . $dateNow->format("Y/m");
                if (!is_dir($imageFolder)) {
                    mkdir($imageFolder, 0777, true);
                }
                // Déplacement de l'image dans /public/uploads/article-images/année-courante/mois-courant/nom-image
                move_uploaded_file($_FILES["article-img"]["tmp_name"], $imageFolder . "/" . $artImageName);
            }
        }
        $art_img = $imageFolder ."/". $artImageName ; // Lien vers l'image dans le dossier

        $bdd = BDD::getInstance();
        $request = "INSERT INTO article(art_title, art_resume, art_content, art_slug, cli_id, art_image) VALUES (:title, :resume, :content, :slug, :cli_id, :img);";
        try {
            $req = $bdd->prepare($request);
            $req->bindParam(':title', $title);
            $req->bindParam(':resume', $resume);
            $req->bindParam(':content', $content);
            $req->bindParam(':slug', $slug);
            $req->bindParam(':cli_id', $cli_id);
            $req->bindParam(':img', $art_img);
            $req->execute();

        } catch(\PDOException $exception) {
                echo $exception->getMessage();
        }

    }

    //Supprime un article grâce à son id
    public function deleteArticle($id){
        $bdd = BDD::getInstance();
        $request = "DELETE FROM article WHERE art_id=:id ; ";
        try{
            $req = $bdd->prepare($request);
            $req->BindParam(':id', $id);
            $req->execute();
            return true;

        } catch(\PDOException $exception) {
            echo $exception->getMessage();

        }

    }


    // Update de type Supprime et remplace.
    public function updateArticle($datas){
        $id = $datas['art-id'];
        $title = $datas['art-title'];
        $resume = $datas['art-resume'];
        $content = $datas['art-content'];

        $bdd = BDD::getInstance();
        $request = "UPDATE article
                    SET art_title = :title, art_resume = :resume, art_content=:content
                    WHERE art_id=:id ; ";

        try{
            $req = $bdd->prepare($request);
            $req->BindParam(':title', $title);
            $req->BindParam(':resume', $resume);
            $req->BindParam(':content', $content);
            $req->BindParam(':id', $id);
            $req->execute();
            return true;

        } catch(\PDOException $exception) {
            echo $exception->getMessage();

        }
    }

}