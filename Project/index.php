<!DOCTYPE html>
<html>
<head>
<title>Connexion utilisateur</title>
<link href="style.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
#modal_con {
    border: 2px solid black;
    width: 50%;
    margin-top: 10%;
    padding: 2%;
    background: transparent;
    color: black;
    display: none; /* Pour masquer initialement le formulaire */
}

body {
    background: url('https://cdn.wallpapersafari.com/3/86/WaRyiB.jpg');
    background-size: cover;
}

label {
    float: left;
}

.btn-spiral {
    animation: spiral 1s linear forwards; /* Application de l'animation uniquement lors de l'apparition */
}

@keyframes spiral {
    0% {
        transform: scale(0); /* Bouton invisible au début */
    }
    100% {
        transform: scale(1); /* Bouton visible à la fin */
    }
}
</style>
<script src="index_style.js">
</script>
</head>
<body>
<center>
    <div id="modal_con">
        <center>
            <h3><strong>Connexion</strong></h3>
        </center>
        <form action="" method="post">
            <label for="pseudo">Identifiant_Db : </label>
            <input type="text" name="pseudo" id="pseudo" class="form-control" required><br />
            <label for="id">Id_db :</label>
            <input type="text" name="id" id="id" class="form-control" required>
            <br />
            <input type="submit" name="submit" value="Login" class="btn btn-primary btn-spiral">
        </form>
        <?php
        /*
        Ici nous essayons d'extraire le POST, et créer un objet login en y faisant passer l'id et le nom de l'utilisateur 
        puis on redirige vers les publications sinon on renvoie une erreur. 
        
        */
        if ($_POST) {
            
            extract($_POST);
            include_once "login.php";

            // Créer une instance de la classe Login
            $obj = new Login();

            // Connexion de l'utilisateur
            if ($obj->connexion($id, $pseudo)) {
                // Rediriger vers la page de publications
                header("location:publications.php");
                exit; 
            } else {
                // Afficher un message d'erreur
                echo "<p>Identifiant ou mot de passe incorrect.</p>";
            }
        }
        ?>
    </div>
</center>

</body>
</html>

