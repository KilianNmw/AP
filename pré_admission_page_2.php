<?php

session_start();

// Redirection si le bouton "PRÉCÉDENT" est cliqué
if (isset($_POST['precedent'])) {
    header("Location: accueil_secrétaire.php"); // Redirige vers la page accueil de la pré-admission
    exit();
}

// Redirection si le bouton "SUIVANT" est cliqué
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["suivant"])) {
    // Sauvegarde des données du formulaire dans la session
    $_SESSION['civilité'] = $_POST['civ'];
    $_SESSION['nomnaissance'] = $_POST['nom_naissance'];
    $_SESSION['nomépouse'] = $_POST['nom_epouse'];
    $_SESSION['prénom'] = $_POST['prenom'];
    $_SESSION['datenaissance'] = $_POST['date_naissance'];
    $_SESSION['adresse'] = $_POST['adresse'];
    $_SESSION['code_postal'] = $_POST['cp'];
    $_SESSION['ville'] = $_POST['ville'];
    $_SESSION['email'] = $_POST['mail'];
    $_SESSION['téléphone'] = $_POST['tel'];

    $_SESSION['nomconfiance'] = $_POST['nom_confiance'];
    $_SESSION['prénomconfiance'] = $_POST['prénom_confiance'];
    $_SESSION['téléphoneconfiance'] = $_POST['téléphone_confiance'];
    $_SESSION['adresseconfiance'] = $_POST['adresse_confiance'];

    $_SESSION['nomcontacter'] = $_POST['nom_contacter'];
    $_SESSION['prénomcontacter'] = $_POST['prénom_contacter'];
    $_SESSION['téléphonecontacter'] = $_POST['téléphone_contacter'];
    $_SESSION['adressecontacter'] = $_POST['adresse_contacter'];

    header("Location: pré_admission_page_3.php"); // Redirige vers la page3 de la pré_admission
    exit();

    
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="Images/LPFS_logo.png" />
        <title>Pré-admission/page2</title>
        <link rel="stylesheet" href="style_secretaire.css">
    </head>
    <body>
        <form action="deconnexion.php">
            <input type="submit" name="deconnexion" value="Se déconnecter" class="form-btn2">
        </form>
        <div class="form-container">
            <form action="" method="post">
                <img src="Images/LPFS_logo.png" alt="Logo Clinique">
                <h3>Nous vous remercions de bien vouloir remplir avec attention ce formulaire</h3>
                <br>
                <h3>Informations Patient</h3>
                <div class="côte_à_côte">
                    <div class="éléments">
                        <p>Civilité : <span>*</span></p>
                        <select name="civ" id="" required>
                            <option value="">Choix</option>
                            <option value="Homme" <?php echo (isset($_SESSION['civilité']) && $_SESSION['civilité'] == 'Homme') ? 'selected' : ''; ?>>Homme</option>
                            <option value="Femme" <?php echo (isset($_SESSION['civilité']) && $_SESSION['civilité'] == 'Femme') ? 'selected' : ''; ?>>Femme</option>
                        </select>
                    </div>
                    <div class="éléments">
                        <p>Nom de naissance : <span>*</span></p>
                        <input type="text" name="nom_naissance" value="<?php echo isset($_SESSION['nomnaissance']) ? $_SESSION['nomnaissance'] : ''; ?>" placeholder required minlength="2" pattern="[A-Za-z]+">
                    </div>
                    <div class="éléments">
                        <p>Nom d'épouse : <span></span></p>
                        <input type="text" name="nom_epouse" value="<?php echo isset($_SESSION['nomépouse']) ? $_SESSION['nomépouse'] : ''; ?>" minlength="2" pattern="[A-Za-z]+">
                    </div>
                </div>
                <div class="côte_à_côte">
                    <div class="éléments">
                        <p>Prénom : <span>*</span></p>
                        <input type="text" name="prenom" value="<?php echo isset($_SESSION['prénom']) ? $_SESSION['prénom'] : ''; ?>" placeholder required minlength="2" pattern="[A-Za-z]+">
                    </div>
                    <div class="éléments">
                        <p>Date de naissance : <span>*</span></p>
                        <input type="date" name="date_naissance" value="<?php echo isset($_SESSION['datenaissance']) ? $_SESSION['datenaissance'] : ''; ?>" placeholder required>
                    </div>
                </div>
                <p>Adresse <span>*</span></p>
                <input type="text" name="adresse" value="<?php echo isset($_SESSION['adresse']) ? $_SESSION['adresse'] : ''; ?>" placeholder required>
                <div class="côte_à_côte">
                    <div class="éléments">
                        <p>Code Postal <span>*</span></p>
                        <input type="text" name="cp" value="<?php echo isset($_SESSION['code_postal']) ? $_SESSION['code_postal'] : ''; ?>" placeholder required minlength="5" maxlength="5" pattern="[0-9]*">
                    </div>
                    <div class="éléments">
                        <p>Ville <span>*</span></p>
                        <input type="text" name="ville" value="<?php echo isset($_SESSION['ville']) ? $_SESSION['ville'] : ''; ?>" placeholder required minlength="3" pattern="[A-Za-z]+">
                    </div>
                </div>
                <div class="côte_à_côte">
                    <div class="éléments">
                        <p>Email <span>*</span></p>
                        <input type="text" name="mail" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" placeholder required minlength="3">
                    </div>
                    <div class="éléments">
                        <p>Téléphone <span>*</span></p>
                        <input type="text" name="tel" value="<?php echo isset($_SESSION['téléphone']) ? $_SESSION['téléphone'] : ''; ?>" placeholder required minlength="10" maxlength="10" pattern="^0[1-9][0-9]{8}$">
                    </div>
                </div>

                <br>
                <h3>Personne de Confiance</h3>
                <div class="côte_à_côte">
                    <div class="éléments">
                        <p>Nom : <span>*</span></p>
                        <input type="text" name="nom_confiance" value="<?php echo isset($_SESSION['nomconfiance']) ? $_SESSION['nomconfiance'] : ''; ?>" placeholder required minlength="2" pattern="[A-Za-z]+">
                    </div>
                    <div class="éléments">
                        <p>Prénom : <span>*</span></p>
                        <input type="text" name="prénom_confiance" value="<?php echo isset($_SESSION['prénomconfiance']) ? $_SESSION['prénomconfiance'] : ''; ?>" placeholder required minlength="2" pattern="[A-Za-z]+">
                    </div>
                    <div class="éléments">
                        <p>Téléphone : <span>*</span></p>
                        <input type="text" name="téléphone_confiance" value="<?php echo isset($_SESSION['téléphoneconfiance']) ? $_SESSION['téléphoneconfiance'] : ''; ?>" placeholder required minlength="10" maxlength="10" pattern="^0[1-9][0-9]{8}$">
                    </div>
                </div>
                    <p>Adresse : <span>*</span></p>
                    <input type="text" name="adresse_confiance" value="<?php echo isset($_SESSION['adresseconfiance']) ? $_SESSION['adresseconfiance'] : ''; ?>" placeholder required minlength="3">

                <br>
                <br>
                <h3>Personne à Contacter</h3>
                <div class="côte_à_côte">
                    <div class="éléments">
                        <p>Nom : <span>*</span></p>
                        <input type="text" name="nom_contacter" value="<?php echo isset($_SESSION['nomcontacter']) ? $_SESSION['nomcontacter'] : ''; ?>" placeholder required minlength="2" pattern="[A-Za-z]+">
                    </div>
                    <div class="éléments">
                        <p>Prénom : <span>*</span></p>
                        <input type="text" name="prénom_contacter" value="<?php echo isset($_SESSION['prénomcontacter']) ? $_SESSION['prénomcontacter'] : ''; ?>" placeholder required minlength="2" pattern="[A-Za-z]+">
                    </div>
                    <div class="éléments">
                        <p>Téléphone : <span>*</span></p>
                        <input type="text" name="téléphone_contacter" value="<?php echo isset($_SESSION['téléphonecontacter']) ? $_SESSION['téléphonecontacter'] : ''; ?>" placeholder required minlength="10" maxlength="10" pattern="^0[1-9][0-9]{8}$">
                    </div>
                </div>
                    <p>Adresse : <span>*</span></p>
                    <input type="text" name="adresse_contacter" value="<?php echo isset($_SESSION['adressecontacter']) ? $_SESSION['adressecontacter'] : ''; ?>" placeholder required minlength="3">

                <div class="inline-fields">
                <!-- Revenir à la page accueil_secrétaire.php -->
                <input type="submit" name="precedent" value="PRECEDENT" formnovalidate class="form-btn">
                <!-- Passer à la page pré_admission_page_3.php -->
                <input type="submit" name="suivant" value="SUIVANT" class="form-btn">
                </div>
            </form>
        </div>
        <?php
            // Fermer la connexion
            $conn->close();
        ?>
    </body>
</html>