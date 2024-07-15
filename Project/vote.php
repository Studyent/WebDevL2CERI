<?php
session_start();

if (!isset($_SESSION['session_util'])) {
    header("Location: login.php"); 
    exit;
}

$sess_u = $_SESSION['session_util'];
$util = $_GET['util'];

// Informations de connexion à la base de données

$host = "pedago01c.univ-avignon.fr";
$dbname = "etd";
$user = "uapv2403756";
$password = "";

try {
    
        // Connexion à la base de données PostgreSQL

    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérification si l'utilisateur a déjà voté pour cette publication

    $stmt = $pdo->prepare("SELECT * FROM votes WHERE utilisateur = :userdb AND publication = :util");
    $stmt->execute(['userdb' => $sess_u, 'util' => $util]);
    $result = $stmt->fetch();

    if (!$result) {
                // Si l'utilisateur n'a pas encore voté, enregistrement du vote dans la base de données

        $stmt = $pdo->prepare("INSERT INTO votes (utilisateur, publication) VALUES (:userdb, :util)");
        $stmt->execute(['userdb' => $sess_u, 'util' => $util]);
        echo "<script>alert('Vote enregistré !')</script>";
    } else {
        echo "<script>alert('Le vote a déjà été comptabilisé.')</script>";
    }

        // Redirection vers la page des publications après le vote
    echo "<script>window.location='publications.php'</script>";
} catch (PDOException $e) {
    echo "<script>alert('Une erreur est survenue lors de la connexion à la base de données !.')</script>";
    echo "<script>window.location='publications.php'</script>";
}
?>

