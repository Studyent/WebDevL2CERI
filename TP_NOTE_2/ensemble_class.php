<?php

class Utilisateur
{
    public $id;
    public $pseudo;
    public $naissance;
    public $activite; // Nouvelle propriété pour stocker l'activité de l'utilisateur
    public $popularite; // Nouvelle propriété pour stocker la popularité de l'utilisateur

    public function __toString()
    {
        return "<a>" . print_r($this, True) . "</a>";
    }
}

class Publication
{
    public $id;
    public $contenu;
    public $auteur;
    public $categorie;

    public function __toString()
    {
        return "<a>" . print_r($this, True) . "</a>";
    }
}

class Profil
{
    public $id;
    public $contenu;
    public $categorie;

    public function __toString()
    {
        return "<a>" . print_r($this, True) . "</a>";
    }
}

class Connexion
{
    private static $instance = null;
    private static $pdoInstance = null;

    private function __construct()
    {
        $host = "pedago01c.univ-avignon.fr";
        $dbname = "etd";
        $user = "uapv2403756";
        $password = "fmaX9D";

        try {
            self::$pdoInstance = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Connexion();
        }

        return self::$instance;
    }

    public function getPdoInstance()
    {
        return self::$pdoInstance;
    }
}

?>
