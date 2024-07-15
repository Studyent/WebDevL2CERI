<?php

class Utilisateur
{
    public $id;
    public $pseudo;
    public $naissance;

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
        $password = "";

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


$connexion = Connexion::getInstance();
$pdo = $connexion->getPdoInstance();

if ($pdo === null) {
    echo "Erreur: La connexion à la base de données a échoué.";
    exit;
}

