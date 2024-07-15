/*

Cette page rend compte, des profils utilisateurs ainsi que leurs publications.

*/

<?php
session_start();
$sess_u = $_SESSION['session_util'];
if(!$sess_u) {
    header("location:./");
}
?>
<!DOCTYPE html>
<html lang="fr">
<?php require  'ensemble_class.php'; ?>
<title>Les utilisateurs</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="effets.js"></script>
<?php $connexion = Connexion::getInstance();
$pdo = $connexion->getPdoInstance();

$conn = $pdo->query('SELECT * FROM utilisateurs'); ?>
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
  padding: 8px 12px;
  text-decoration: none;
}

li a:hover:not(.active) {
  background-color: #111;
}
li {
float: left;
}

#deco {
  background-color: #;
}

    body {
        font-family: Arial, sans-serif;
    }

    h1, h2, h3, h4, h5, h6, .w3-bar, button {
        font-family: "Gill sans", sans-serif;
    }

    #liste_utilisateurs {
        background-color: #f3e4b1;
        border-collapse: separate;
        border-spacing: 10px;
        border-radius: 10px;
        width: 100%;
    }

    #liste_utilisateurs td, #liste_utilisateurs th {
        background-color: orange;
        padding: 12px;
        border-radius: 8px;
        min-width: 60px;
        height: 60px;
    }

    #liste_utilisateurs tr:nth-child(even) {
        background-color: #472900;
    }

    #liste_utilisateurs tr:hover {
        background-color: #4CAF50;
    }

    #liste_utilisateurs th {
        padding-top: 30px;
        padding-bottom: 30px;
        text-align: left;
        background-color: #ff9800;
        color: white;
    }
</style>

<body>
<script>
    $(function () {
        $("#hide_votes").click(function () {
            $(".votes").slideToggle();
            return false;
        });
    });
</script>
<div class="w3-top">
    <ul>
        <li><a href="index.html" class="w3-bar-item w3-button w3-hide-small w3-padding-large" style="color:#fff">IndexSite</a></li>
	<li><a href="utilisateurs.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large" style="color:#fff">Utilisateurs</a></li>
	<li><a href="statUsers.php" class="w3-bar w3-button w3-hide-small w3-padding-large" style="color:#fff">Statistiques</a></li>
        <li><a href="publications.php" class="w3-bar w3-button w3-hide-small w3-padding-large" style="color:#fff">Publications</a></li>

        <li><a id="deco" href="logout.php">Déconnexion</a></li>
    </ul>
</div>

<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div class="w3-twothird">
            <table style="text-align: center;" id="liste_utilisateurs">
                <thead>
                <tr>
                    <th>pseudo</th>
                    <th>naissance</th>
                    <th>profil</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // Récupération des utilisateurs depuis la base de données
                $conn = $pdo->query('SELECT * FROM utilisateurs');
                $conn->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
                while ($res = $conn->fetch()):
                    ?>
                    <tr>
                        <td><?php echo $res->pseudo; ?></td>
                        <td><?php echo $res->naissance; ?></td>
                        <td><a href="profil.php?id=<?php echo $res->id; ?>">Voir publications</a></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>

    // Fonction JavaScript pour afficher/masquer le menu sur les petits écrans
    function myFunction() {
        var x = document.getElementById("navDemo");
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }
</script>
</body>
</html>

