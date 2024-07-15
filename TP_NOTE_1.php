<!DOCTYPE html>
<html
 lang="en">
<?php

/*

Il semblerait y avoir un problème avec mon code qui lorsque je configurer les zones cela fonctionner, elles s'affichaient, mais après cela une fois
que j'ai "merged" les fichiers à la fin, cela ne fonctionne plus.


*/

abstract class Parcelle {
    protected string $nom_parc;
    protected bool $etatbool;

    
    public function __construct($nom) {
        $this->nom = $nom;
        $this->etatVanne = "fermée"; 
    }
    public function ouvrirVanne() {
        echo "Vanne à ouvrir ouvrir {$this->nom}\n";
        $this->etatVanne = "ouverte";
        return $this; 
    }

    public function fermerVanne($delai) {
        echo "Fermeture en cours sur {$this->nom} avec un délai de {$delai} secondes\n";
        sleep($delai); 
        $this->etatVanne = "fermée";
        return $this; 
    }

    public function etatVanne() {
        echo "Vanne {$this->nom} - État : {$this->etatVanne}\n"; 
    }

    public static function opVannes(array $parcelles, string $ope, array $args = []) {
        foreach ($parcelles as $parcelle) {
            $fonction = [$parcelle, $ope];
            if (is_callable($fonction)) {
                call_user_func_array($fonction, $args);
            }
        }
    }

    public function arroser() {
        echo "Arrose la parcelle\n";
    }
    

}


class Maraicher extends Parcelle{


    public function __construct($nom) {
        parent::__construct($nom);
    }

    public function arroser() {
        echo "Arrosage en cours sur la parcelle maraîchère {$this->nom}\n";
        
    }

}

class Cerealier extends Parcelle{

    public function arroser() {
        echo "Arrosage du céréalier \n";
        
    }

    
}


class Fruitier extends Parcelle{

    public function arroser() {
        echo "Arrosage du Fruitier \n";
        
    }

    
}


class Pepiniere extends Parcelle{

    public function arroser() {
        echo "Arrosage de la pépinière \n";
        
    }
    
}

/*
$parcelle1 = new Maraicher("ParcelleMa");
$parcelle2 = new Cerealier("ParcelleCerea");
$parcelle3 = new Fruitier("ParcelleFruit");
$parcelle4 = new Pepiniere("ParcellePepi");

Parcelle::opVannes([$parcelle1, $parcelle2, $parcelle3, $parcelle4], "ouvrirVanne");
Parcelle::opVannes([$parcelle1, $parcelle2], "fermerVanne", [3]);
Parcelle::opVannes([$parcelle3, $parcelle4], "fermerVanne", [5]);
Parcelle::opVannes([$parcelle1, $parcelle2, $parcelle3, $parcelle4], "etatVanne");
*/
/*
Vanne à ouvrir ouvrir ParcelleMa Vanne à ouvrir ouvrir ParcelleCerea Vanne à ouvrir ouvrir ParcelleFruit Vanne à ouvrir 
ouvrir ParcellePepi Fermeture en cours sur ParcelleMa avec un délai de 3 secondes Fermeture en cours sur ParcelleCerea avec 
un délai de 3 secondes Fermeture en cours sur ParcelleFruit avec un délai de 5 secondes Fermeture en cours sur ParcellePepi 
avec un délai de 5 secondes Vanne ParcelleMa - État : 
fermée Vanne ParcelleCerea - État : fermée Vanne ParcelleFruit - État : fermée Vanne ParcellePepi - État : fermée 

*/




session_start();

if (isset($_POST['reset'])) {
    unset($_SESSION['zone_culture']);
}

// opérations sur les parcelles
if (isset($_POST['realiser_operations'])) {

    if (isset($_SESSION['zone_culture'])) {
     
        foreach ($_SESSION['zone_culture'] as $index => $parcelle) {

            if ($parcelle['verrouillage'] === true) {
                // Si la parcelle est verrouillée, on la déverrouille
                $_SESSION['zone_culture'][$index]['verrouillage'] = false;
            } else {
                // déverrouillée on verrouille
                $_SESSION['zone_culture'][$index]['verrouillage'] = true;
            }
        }

        // Redirection vers la même page pour rafraîchir 
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
       
        echo "La zone de culture n'est pas encore configurée.";
    }
}

// Vérifiez si les index sont définis dans $_POST
if (isset($_POST['configurer'])) {
    $nb_parcelles = $_POST['nb_parcelles'];
    $nom_parcelles = isset($_POST['nom_parcelle']) ? $_POST['nom_parcelle'] : array();
    $type_parcelles = isset($_POST['type_parcelle']) ? $_POST['type_parcelle'] : array();

    $zone_culture = array();

    for ($i = 0; $i < $nb_parcelles; $i++) {
        $nom = isset($nom_parcelles[$i]) ? $nom_parcelles[$i] : '';
        $type = isset($type_parcelles[$i]) ? $type_parcelles[$i] : '';
        $zone_culture[] = array(
            'nom' => $nom,
            'type' => $type,
            'verrouillage' => false
        );
    }

    $_SESSION['zone_culture'] = $zone_culture;
}
?>

<head>
    <title>W3.CSS Template</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body, h1,  h2, h3,h4, h5,h6 {
            font-family: "Lato", sans-serif
        }.w3-bar,h1, button {
            font-family: "Montserrat", sans-serif
        }

        .fa-anchor,
        .fa-coffee {
            font-size: 200px
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-red w3-card w3-left-align w3-large">
            <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large w3-white">Home</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Link 1</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Link 2</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Link 3</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Link 4</a>
            <!--- BOUTTON JQUERY -->
            <button id="Btncolon">Cacher/ou non les opérations</button>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Cacher les colonnes des opérations par défaut
        $("tr td:nth-child(4), tr td:nth-child(5)").hide();
        
        // Lorsque le bouton est cliqué, cacher/révéler les colonnes des opérations
        $("#Btncolon").click(function() {
            $("tr td:nth-child(4), tr td:nth-child(5)").toggle();
        });
    });
</script>



        </div>

        <!-- Navbar on small screens -->
        <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
            <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 1</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 2</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 3</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 4</a>
        </div>
    </div>

    <!-- Header -->
    <header class="w3-container w3-red w3-center" style="padding:128px 16px">
        <h1 class="w3-margin w3-jumbo">START PAGE</h1>
        <p class="w3-xlarge">Template by w3.css</p>
        <button class="w3-button w3-black w3-padding-large w3-large w3-margin-top">Get Started</button>
    </header>

    <!-- Form to configure the zone -->
    <div class="w3-container w3-padding">
    <h2>Configuration de la zone de culture</h2>
    <form method="post">
        <label for="nb_parcelles">Nombre de parcelles :</label>
        <input type="number" id="nb_parcelles" name="nb_parcelles" min="1"><br><br>
        <table class="w3-table">
            <tr>
                <th>Nom de la parcelle</th>
                <th>Type de parcelle</th>
            </tr>
            <?php
            // Vérifiez si les index sont définis dans $_POST
            if (isset($_POST['configurer'])) {

                // Boucle à travers chaque parcelle pour les afficher dans le tableau
                for ($i = 0; $i < $_POST['nb_parcelles']; $i++) {
            ?>
                    <tr>
                        <td><input type="text" name="nom_parcelle[]"></td>
                        <td>
                            <select name="type_parcelle[]">
                                <option value="maraicher">Maraicher</option>
                                <option value="cerealier">Cerealier</option>
                                <option value="fruitier">Fruitier</option>
                                <option value="pepiniere">Pepiniere</option>
                            </select>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </table><br>
        <input type="submit" name="configurer" value="Configurer la zone">
        <input type="submit" name="reset" value="Réinitialiser">
    </form>

    <!-- Affichage des informations des parcelles configurées -->
    <?php if (isset($_SESSION['zone_culture'])) { ?>
<div class="w3-container w3-padding">
    <h2>Zone de culture configurée</h2>
    <table class="w3-table">
        <tr>
            <th>Nom de la parcelle</th>
            <th>Type de parcelle</th>
            <th>État de verrouillage</th>
            <th>Action - Ouverture</th>
            <th>Action - Fermeture</th>
        </tr>
        <?php foreach ($_SESSION['zone_culture'] as $parcelle) { ?>
            <tr>
                <td><?php echo $parcelle['nom']; ?></td>
                <td><?php echo $parcelle['type']; ?></td>
                <td><?php echo $parcelle['verrouillage'] ? 'Verrouillée' : 'Déverrouillée'; ?></td>
                <td> <!-- Action pour ouvrir la parcelle --> </td>
                <td> <!-- Action pour fermer la parcelle --> </td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php } ?>
        </table><br>
        <form method="post">
            <input type="submit" name="realiser_operations" value="Réaliser toutes les opérations">
        </form>
    </div>

    <div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
        <h1 class="w3-margin w3-xlarge">Quote of the day: live life</h1>
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-padding-64 w3-center w3-opacity">
        <div class="w3-xlarge w3-padding-32">
            <i class="fa fa-facebook-official w3-hover-opacity"></i>
            <i class="fa fa-instagram w3-hover-opacity"></i>
            <i class="fa fa-snapchat w3-hover-opacity"></i>
            <i class="fa fa-pinterest-p w3-hover-opacity"></i>
            <i class="fa fa-twitter w3-hover-opacity"></i>
            <i class="fa fa-linkedin w3-hover-opacity"></i>
        </div>
        <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </footer>

    <script>
        // Used to toggle the menu on small screens when clicking on the menu button
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
