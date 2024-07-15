<?php
	

class RequeteIns
{
    public $host = "pedago01c.univ-avignon.fr";
    public $dbname = "etd";
    public $user = "uapv2403756";
    public $password = "fmaX9D";

//fonction avec rapport d'erreur sql, insertion et/ou écrasement des données

function publication($id, $category, $contenu, $auteur)
{
    try {
        $pdo = new PDO("pgsql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($id) {
            

		// préparation de la requete + update
            $query = $pdo->prepare("UPDATE publications SET contenu = ?, auteur = ?, categorie = ? WHERE id = ?");
            $query->execute([$contenu, $auteur, $category, $id]);
        } else {
            // insertion sinon
            $query = $pdo->prepare("INSERT INTO publications (contenu, auteur, categorie) VALUES (?, ?, ?)");
            $query->execute([$contenu, $auteur, $category]);
        }

        return $query;
    } catch (PDOException $e) {
        
        echo "L'insertion n'a pas pu s'effectuer: " . $e->getMessage();
    }
}


}
?>
