<?php

// class Login + pdo permettant de de préparer la connexion à la db

class Login
{
    private $pdo;

    public function __construct()
    {
        $host = "pedago01c.univ-avignon.fr";
        $dbname = "etd";
        $user = "uapv2403756";
        $password = "";

        try {
            $this->pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
    }

/*

Fonction connexion permettant de faire la requete pour savoir si la personne que l'on a rentré dans l'index, existe dans la db

Si il y a une correspondance, l'on créer une session avec l'id $sess_u qui nous servira pour effectuer nos taches.
sinon l'on renvoie false si aucune correspondance, ou erreur s'il y a eu un autre problème
*/

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

