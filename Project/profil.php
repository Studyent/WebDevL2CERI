<!DOCTYPE html>
<html lang="fr">
<?php require 'ensemble_class.php'; ?> // Inclusion du fichier 'ensemble_class.php' pour nos classes
<title>Profil</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="effets.js"></script>
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

<div class="w3-top">

    <ul>
  <li><a href="utilisateurs.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large" style="color:#fff">Utilisateurs</a></li>

  <li><a id="deco" href="logout.php">Déconnexion</a></li>
</ul>
</div>

<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div class="w3-twothird">
            <button id="hide_votes" class="w3-button">Hide votes</button>

            <table id="utilisateur" class="w3-table">
                <thead>
                <tr>
                    <th>Contenu</th> <th>Categorie</th>
                    <th class="votes">Votes</th>
                </tr>
                </thead>
                <tbody>

                // Requête pour récupérer les publications d'un auteur;

                <?php
                $request = 'select p.id, p.contenu, c.categorie from publications p
                    inner join categories c on c.id = p.categorie
                    where auteur=' . (string)$_GET['id'] . ' order by c.id DESC';
                $conn = $pdo->query($request);
                $conn->setFetchMode(PDO::FETCH_CLASS, 'Profil');
                                    // Boucle pour afficher chaque publication
                while ($res = $conn->fetch()):
                ?>

                <?php
                 // Requête pour récupérer les utilisateurs ayant voté pour chaque publication
                $users_voting_query = "select u.id as users from utilisateurs u
                    join votes v on u.id = v.utilisateur
                    join publications p on p.id = v.publication
                    where p.id=$res->id";


                $conn2 = $pdo->query("select u.pseudo from utilisateurs u
                    full outer join publications p on u.id = p.auteur
                    full outer join votes v on p.id = v.publication
                    where u.id in ($users_voting_query)
                    GROUP BY u.id
                    ORDER BY count(v.id) DESC");
                // Extraction des utilisateurs ayant voté pour chaque publications

                $vote = array_map(function ($elem) {
                    return $elem['pseudo'];
                }, $conn2->fetchAll());
                ?>
                <tr class="publication">
                    <td><?php echo $res->contenu; ?></td>
                    <td><?php echo $res->categorie; ?></td>
                    <td class="votes"><?php echo $vote ? join('|', $vote) : 'NA' ?></td>
                </tr>

                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    .publication {
        transition: transform 0.3s ease; /* Ajout de la transition pour l'effet d'échelle */
    }
</style>

<script>
$(document).ready(function() {
    $(".publication").hover(function() {
        $(this).css("transform", "scale(1.1)");
    }, function() {
        $(this).css("transform", "scale(1)");
    });

    // Changement de couleur du nom de l'utilisateur au passage de la souris
    $(".utilisateur").hover(function() {
        $(this).css("color", "blue");
    }, function() {
        $(this).css("color", "black");
    });

    // Script pour le bouton "Hide votes"
    $("#hide_votes").click(function() {
        $(".votes").toggle();
    });
});
</script>

</body>
</html>

