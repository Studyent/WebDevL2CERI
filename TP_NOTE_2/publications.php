<?php
session_start();

// Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
if (!isset($_SESSION['session_util'])) {
    header("Location: ./login.php");
    exit;
}

// Récupère l'ID utilisateur de la session
$sess_u = $_SESSION['session_util'];
?>
<!DOCTYPE html>
<html lang="fr">
<?php require 'ensemble_class.php'; ?>
<title>Publications</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="effets.js"> </script>
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
  background-color: #;
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
  <li><a href="statUsers.php" class="w3-bar w3-button w3-hide-small w3-padding-large" style="color:#fff">Statistiques</a></li>	
<li><a href="publications.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large" style="color:#fff">publications</a></li>
        <li><a href="utilisateurs.php" class="w3-bar w3-button w3-hide-small w3-padding-large" style="color:#fff">Utilisateurs</a></li>

  <li><a id="deco" href="logout.php">Déconnexion</a></li>
</ul>
</div><div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div class="w3-twothird">
                <?php
                        include "donnee.php";
                        $obj = new Donnee();
                        $query = $obj->query("SELECT * FROM categories JOIN publications ON categories.id=publications.categorie");
                ?>
                <h2><center>Publications</center></h2>
                <center><a href="#"  class="w3-button w3-blue" onclick="document.getElementById('lemodal').style.display='block'">Ajouter une nouvelle publication</a></center>
                <br /><br />
                <table id="lutilisateur" style="background-color: #FEE548;">
                <tr>

                <th style="background-color: orange;">Catégorie</th>
                <th style="background-color: orange;">Article</th>
                <th style="background-color: orange;">Auteur</th>

                <th></th>
                        </tr>
                        <?php
                                while($req = $query->fetch(PDO::FETCH_ASSOC))
                                {
                                        ?>
                                        <tr style="background-color: #FEB048;">
                            <?php
                                $iden = $req['categorie'];
                                $selection = $obj->query("SELECT * FROM categories WHERE id='$iden'");
                                while($i = $selection->fetch(PDO::FETCH_ASSOC))
                                {
                                    $nom_cat = $i['categorie'];
                            ?>
                                                <td><a href="publicationsCategories.php?id=<?php echo $req['categorie']; ?>"><?php echo $nom_cat; ?></a></td>
                            <?php } ?>
                                                <td><?php echo $req['contenu']; ?></td>
                                                <td><?php echo $req['auteur']; ?></td>
                            <td>
                                <a href="vote.php?util=<?php echo $req['id']; ?>" class="w3-button">Vote</a>
                            </td>
                                        </tr>
                                        <?php
                                }
                        ?>
                </table>
        </div>
    </div>
</div>

<div id="lemodal" class="w3-modal">
    <div class="w3-modal-content">
      <header class="w3-container w3-blue-grey">
        <span onclick="document.getElementById('lemodal').style.display='none'"
        class="w3-button w3-display-topright">&times;</span>
        <h2>Fenetre d'édition</h2>
      </header>
      <div class="w3-container">
        <br />
        <form action="" method="post" class="w3-container">
                <label>Catégories :</label> <select class="w3-input w3-border" name="category">
                        <option>-- Sélectionner une catégorie --</option> <?php
                        $query = $obj->query("SELECT * FROM categories");
                        while($i = $query->fetch(PDO::FETCH_ASSOC))
                        {
                                ?>
                                <option value="<?php echo $i['id']; ?>"><?php echo $i['categorie']; ?></option>
                                <?php
                        }
                ?>
                </select>
                <label>Auteur :</label>
                <input type="text" name="auteur" class="w3-input w3-border" value="<?php echo htmlspecialchars($sess_u); ?> " readonly>
                <br />
                <label>Contenu :</label>
                <textarea name="contenu" class="w3-input w3-border"></textarea>
                <br />
                <input type="submit" name="save" value="Publier!" class="w3-button w3-yellow" style="border-radius: 3px; width:150px">
        </form>
        <br />
      </div>
    </div>
  </div>
<?php
if($_POST)
{
    include_once "requete_insert.php";
        extract($_POST);
        $obj = new RequeteIns();
        $publi = $obj->publication($sess_u,$category,$contenu,$auteur);
        if($publi)
        {
                echo "<script>alert('Votre publication a été publié avec succès !');</script>";
        }
        else
        {
                echo "<script>alert('Une erreur est survenu lors de la publication de votre contenu, merci de réessayer !');</script>";
        }
}

?>
<script>

function myFunction() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>
