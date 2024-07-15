<?php

class Login
{
    private $pdo;

    public function __construct()
    {
        $host = "pedago01c.univ-avignon.fr";
        $dbname = "etd";
        $user = "uapv2403756";
        $password = "fmaX9D";

        try {
            $this->pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
    }

    public function connexion($sess_u, $nickname)
    {
        try {
            $query = "SELECT * FROM utilisateurs WHERE pseudo=:nickname AND id=:userdb";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(array(':nickname' => $nickname, ':userdb' => $sess_u));

            if ($stmt->rowCount() == 0) {
                return false;
            } else {
                session_start();
                $_SESSION['session_util'] = $sess_u;
                return true;
            }
        } catch (PDOException $e) {
            echo "Erreur de requête : " . $e->getMessage();
            return false;
        }
    }
}

?>

