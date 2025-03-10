<?php
session_start();
if (isset($_POST['submit'])) {
    $Captcha = htmlspecialchars($_POST['captcha']);
    if (isset($Captcha) && isset($_SESSION['captcha']) && $Captcha === $_SESSION['captcha']) {
        if (isset($_POST['nom']) && isset($_POST['mdp'])) {
            $nom = $_POST['nom'];
            $mdp = $_POST['mdp'];
            $erreur = "";
            $nom_serveur = "localhost";
            $utilisateur = "root";
            $mot_de_passe = "sio2024";
            $nom_base_données = "LPFS_Clinique";
            $con = mysqli_connect($nom_serveur, $utilisateur, $mot_de_passe, $nom_base_données);
            
            // Vérifiez la connexion
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $req = mysqli_query($con, "SELECT identifiant, motdepasse, id_rôle FROM Personnels WHERE identifiant= '$nom' AND motdepasse= '$mdp'");
            $num_ligne = mysqli_num_rows($req);
            if ($num_ligne > 0) {
                // Récupérez les données sous forme de tableau associatif
                $row = mysqli_fetch_assoc($req);
                $métier = $row['id_rôle']; // Récupération de la valeur de id_rôle
                
                // Utilisez la valeur de $métier pour rediriger
                if ($métier == "1") {
                    $_SESSION['nom'] = $nom; // Stocker le nom dans la session
                    header("Location: accueil_admin.php");
                } elseif ($métier == "2") {
                    $_SESSION['nom'] = $nom; // Stocker le nom dans la session
                    header("Location: accueil_secrétaire.php");
                } else {
                    $_SESSION['nom'] = $nom; // Stocker le nom dans la session
                    header("Location: accueil_médecin.php");
                }
                exit(); // Toujours utiliser exit après header
            } else {
                $erreur = "Adresse mail ou Mot de passe incorrect !";
                // Vous pouvez afficher l'erreur si nécessaire
            }
        }
    } else {
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Le captcha est incorrect.');
        window.location.href='index.php';
        </script>");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="Images/LPFS_logo.png" />
        <title>Page de Connexion</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="left">
            <div class="form-container">
                <form action="" method="post">
                    <h3>Connexion</h3>
                    <?php
                        if(isset($erreur)){
                            echo "<p style='color:red;'>" . $erreur . "</p>";
                        }         
                    ?>
                    <?php
                        if(isset($validation)){
                            echo "<p style='color:green;'>" . $validation . "</p>";
                        }         
                    ?>
                    <input type="text" name="nom" required placeholder="Entrer votre nom">
                    <input type="password" name="mdp" required placeholder="Entrez votre mot de passe">
                    <input class="input" id="captcha" type="text" name="captcha" placeholder="Recopier le code ci-dessous" required>
                    <img src="captcha.php" style=" display: block,; color: #212529;font-size:3rem;" />
                    <input type="submit" name="submit" value="Se connecter" class="form-btn">
                    <a href="motdepasse.php">Mot de passe oublié ?</a>
                    <p>Vous n'avez pas de compte ? <a href="inscription.php">Inscrivez-vous maintenant</a></p>
                </form>
            </div>
        </div>
        <div class="right">
            <img src="Images/LPFS_logo.png" class="Logo" alt="Logo Clinique">
        </div>
    </body>
    <script>
        // Empêcher le retour arrière du navigateur
            window.history.pushState(null, '', window.location.href);
            window.onpopstate = function () {
                window.history.pushState(null, '', window.location.href);
            };
    </script>
</html>
