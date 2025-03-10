<?php
    session_start();
    if(isset($_POST['submit'])){
        $nom = $_POST['nom'];
        $mdp = $_POST['mdp_new'];
        $erreur = "";
        $validation = "";
        $nom_serveur = "localhost";
        $utilisateur = "root";
        $mot_de_passe = "sio2024";
        $nom_base_données = "LPFS_Clinique";
        $con = mysqli_connect($nom_serveur, $utilisateur, $mot_de_passe, $nom_base_données);
        $req = mysqli_query($con, "UPDATE Professionnels SET motdepasse= '$mdp' WHERE nom_pro= '$nom'");
        header("Location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Page de Connexion</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="form-container">
            <form action="" method="post">
                <h3>Changement Mot de passe</h3>
                <?php
                    if(isset($erreur)){
                        echo "<p style='color:red;'>" . $erreur . "</p>";
                    }         
                ?>
                <input type="text" name="nom" required placeholder="Entrer votre nom">
                <input type="password" name="mdp_new" required placeholder="Entrez le dernier mot de passe connu">
                <input type="password" name="mdp_new" required placeholder="Entrez votre nouveau mot de passe">
                <input type="password" name="mdp_confirm" required placeholder="Confirmez votre nouveau mot de passe">
                <input type="submit" name="submit" value="Modifier" class="form-btn">
                <p>Déjà un compte ? <a href="index.php">Connectez-vous</a></p>
            </form>
        </div>
    </body>
</html>