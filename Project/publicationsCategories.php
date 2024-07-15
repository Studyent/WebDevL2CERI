<?php
session_start();
// Récupération de la session utilisateur
$sess_u = $_SESSION['session_util'];
if (!$sess_u) {
    header("location:./");
    exit;
}

include_once 'donnee.php';
// Récupération de l'ID de la catégorie depuis l'URL renvoie 0 sinon
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id == 0) {
    echo "ID de catégorie non valide.";
    exit;
}

$objDonnee = new Donnee();
$queryCategories = $objDonnee->query("SELECT * FROM categories WHERE id = ?", [$id]);
while ($category = $queryCategories->fetch(PDO::FETCH_ASSOC)) {
    $categoryName = $category['categorie'];//ici on récupère la nom de la catégorie
}
$queryPublications = $objDonnee->query("SELECT * FROM publications WHERE categorie = ?", [$id]);
?>
<!DOCTYPE html>
<html lang="fr">
<?php require 'ensemble_class.php'; ?>
<title>Publications Catégories</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    h1, h2, h3, h4, h5, h6, .w3-bar, button {
        font-family: "Gill sans", sans-serif;
    }

    #utilisateur {
        background-color: #f3e4b1;
        border-collapse: separate;
        border-spacing: 10px;
        border-radius: 10px;
        width: 100%;
    }

    #utilisateur td, #utilisateur th {
        background-color: orange;
        padding: 15px;
        border-radius: 10px;
        min-width: 50px;
        height: 50px;
    }

    #utilisateur tr:nth-child(even) {
        background-color: #472900;
    }

    #utilisateur tr:hover {
        background-color: #4CAF50;
    }

    #utilisateur th {
        padding-top: 25px;
        padding-bottom: 25px;
        text-align: left;
        background-color: #ff9800;
        color: white;
    }
</style>

<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #0BBCC9;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover:not(.active) {
  background-color: #111;
}
li {
float: left;
}

#deco {
  background-color: #fff;
}
</style>

<body>
<div class="w3-top">
    <ul>
        <li><a href="utilisateurs.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large" style="color:#fff">Utilisateurs</a></li>
        <li><a id="deco" href="logout.php">Déconnexion</a></li>
    </ul>
</div>

<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div class="w3-twothird">
            <h2>Contenu de <?php echo $categoryName; ?></h2>
            <table id="utilisateur">
                <thead>
                    <tr>
                        <th>Contenu</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                    // l'on fait une boucle pour afficher le contenu des publications.
                    while ($publication = $queryPublications->fetch(PDO::FETCH_ASSOC)) { ?>
                        <tr>
                            <td><?php echo $publication['contenu']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>

