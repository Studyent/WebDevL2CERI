	<?php
session_start();

// Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
if (!isset($_SESSION['session_util'])) {
    header("Location: ./login.php");
    exit;
}

require_once('ensemble_class.php');

// Récupérer la connexion à la base de données
$connexion = Connexion::getInstance();
$pdo = $connexion->getPdoInstance();

// Vérifier si la connexion est établie
if ($pdo === null) {
    echo "Erreur: La connexion à la base de données a échoué.";
    exit;
}

// Requête SQL pour récupérer nos stats
$sql = "SELECT u.id, u.pseudo, 
               COUNT(DISTINCT p.id) + COUNT(DISTINCT v.id) AS activite, 
               SUM(COALESCE(votes.nb_votes, 0)) AS popularite, 
               (SELECT c.categorie 
                FROM publications pub 
                INNER JOIN categories c ON pub.categorie = c.id 
                WHERE pub.auteur = u.id 
                GROUP BY c.categorie 
                ORDER BY COUNT(*) DESC 
                LIMIT 1) AS categorie_principale
        FROM utilisateurs u
        LEFT JOIN publications p ON u.id = p.auteur
        LEFT JOIN votes v ON p.id = v.publication
        LEFT JOIN (SELECT publication, COUNT(*) AS nb_votes FROM votes GROUP BY publication) AS votes ON p.id = votes.publication
        GROUP BY u.id, u.pseudo
        ORDER BY activite DESC";

$stmt = $pdo->query($sql);
if ($stmt) {
    $users = $stmt->fetchAll(PDO::FETCH_CLASS, 'Utilisateur');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les statistiques</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="effets.js"></script>
</head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: orange; 
            border-radius: 10px; 
            min-width: 60px; 
            height: 60px; 
        }
        th {
            background-color: #ff9800;
            color: white;
            padding-top: 30px;
            padding-bottom: 30px;
        }
</style>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1, h2, h3, h4, h5, h6, .w3-bar, button {
            font-family: "Gill sans", sans-serif;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #0BBCC9;
        }

        li {
            float: left;
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

        #deco {
            background-color: #;
        }
    </style>
<body>
<div class="w3-top">
    <ul>
        <li><a href="utilisateurs.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large" style="color:#fff">Utilisateurs</a></li>
        <li><a href="statUsers.php" class="w3-bar w3-button w3-hide-small w3-padding-large" style="color:#fff">Statistiques</a></li>
        <li><a href="publications.php" class="w3-bar w3-button w3-hide-small w3-padding-large" style="color:#fff">Publications</a></li>
        <li><a id="deco" href="logout.php">Déconnexion</a></li>
    </ul>
</div>




<div class="container">
    <h2>Statistiques des Utilisateurs</h2>
    <input type="number" id="popularityFilter" placeholder="Filtrer par popularité">
	<button id="filterButton">Filtrer</button>
    <table>
        <tr>
            <th>Utilisateur</th>
            <th>Activité</th>
            <th>Popularité</th>
            <th>Catégorie Principale</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user->pseudo); ?></td>
                <td><?php echo $user->activite; ?></td>
                <td><?php echo $user->popularite; ?></td>
                <td><?php echo htmlspecialchars($user->categorie_principale); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>

<?php
} else {
    echo "Erreur lors de l'exécution de la requête SQL.";
}
?>
<script>
 $(document).ready(function() {
    // Filtrer les utilisateurs en fonction de la popularité saisie
    $('#filterButton').click(function() {
        var filterValue = parseInt($('#popularityFilter').val()); // Convertir en entier car input value <text>
        $('table tbody tr').each(function() {
            var popularity = parseInt($(this).find('td:eq(2)').text());
            if (popularity < filterValue) {
                $(this).fadeOut(); // Animation de disparition
            } else {
                $(this).fadeIn(); // Animation d'apparition
            }
        });
    });

    // Fonctionnalité au survol pour rendre l'animation fluide
    $('table tbody tr').hover(function() {
        $(this).stop().animate({ backgroundColor: '#f2f2f2' }, 'fast');
    }, function() {
        $(this).stop().animate({ backgroundColor: '' }, 'fast');
    });

// fonctionnalité de zoom
$('table tbody tr').hover(function() {
        $(this).stop().animate({ 'font-size': '1.1em' }, 'fast'); // Zoom avant
    }, function() {
        $(this).stop().animate({ 'font-size': '1em' }, 'fast'); // Zoom arrière
    });

});


</script>

<script>



</script>

