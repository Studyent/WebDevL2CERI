<?php

class Donnee
{
    public $host = "pedago01c.univ-avignon.fr";
    public $dbname = "etd";
    public $user = "uapvxxxxxx";
    public $password = "";

    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("pgsql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
    }

   public function query($sql, $params = [])
{
    try {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        echo "Erreur de requête : " . $e->getMessage();
    }
}

}

?>

