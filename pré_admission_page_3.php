<?php
session_start(); // Démarre la session

// Connexion à la base de données
$serveur = "localhost";
$nomutilisateur = "root";
$motdepasse = "sio2024";
$nombdd = "LPFS_Clinique";  

$conn = new mysqli($serveur, $nomutilisateur, $motdepasse, $nombdd);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Requête pour récupérer les chambres
$sql = "SELECT num_chambre, type_chambre FROM Chambres";
$result = $conn->query($sql);

// Redirection si le bouton "PRÉCÉDENT" est cliqué
if (isset($_POST['precedent'])) {
    // Redirige vers la page précédente sans perdre les données
    header("Location: pré_admission_page_2.php"); // Redirection vers la page2
    exit();
}

// Redirection si le bouton "SUIVANT" est cliqué
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["suivant"])) {
    // Sauvegarde des données du formulaire dans la session
    $_SESSION['organisme'] = $_POST['organisme'];
    $_SESSION['numéro_sécurité_sociale'] = $_POST['numsécu'];
    $_SESSION['assuré'] = $_POST['assuré'];
    $_SESSION['ald'] = $_POST['ald'];
    $_SESSION['nomassurance'] = $_POST['nomassurance'];
    $_SESSION['numéro_adhérent'] = $_POST['numadhérent'];
    $_SESSION['chambre_selection'] = $_POST['chambre']; // Sauvegarde de la valeur concaténée

    header("Location: pré_admission_page_4.php"); // Redirige vers la page4
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
        <title>Pré-admission/page3</title>
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
                <h3>Couverture Sociale du Patient</h3>
                <p>Organisme de Sécurité Sociale/ Nom de la caisse d'assurance maladie : <span>*</span></p>
                <input type="text" name="organisme" value="<?php echo isset($_SESSION['organisme']) ? $_SESSION['organisme'] : ''; ?>" placeholder required minlength="3" pattern="[A-Za-z]+">
                <p>Numéro Sécurité Sociale : <span>*</span></p>
                <input type="text" name="numsécu" value="<?php echo isset($_SESSION['numéro_sécurité_sociale']) ? $_SESSION['numéro_sécurité_sociale'] : ''; ?>" placeholder required minlength="13" maxlength="13" pattern="[0-9]*">
                <div class="côte_à_côte">
                    <div class="éléments">
                        <p>Le patient est-il assuré ? <span>*</span></p>
                        <select name="assuré" id="" required>
                            <option value="">Choix</option>
                            <option value="Oui" <?php echo (isset($_SESSION['assuré']) && $_SESSION['assuré'] == 'Oui') ? 'selected' : ''; ?>>Oui</option>
                            <option value="Non" <?php echo (isset($_SESSION['assuré']) && $_SESSION['assuré'] == 'Non') ? 'selected' : ''; ?>>Non</option>
                        </select>
                    </div>
                    <div class="éléments">
                        <p>Le patient est-il en ALD ? <span>*</span></p>
                        <select name="ald" id="" required>
                            <option value="">Choix</option>
                            <option value="Oui" <?php echo (isset($_SESSION['ald']) && $_SESSION['ald'] == 'Oui') ? 'selected' : ''; ?>>Oui</option>
                            <option value="Non" <?php echo (isset($_SESSION['ald']) && $_SESSION['ald'] == 'Non') ? 'selected' : ''; ?>>Non</option>
                        </select>
                    </div>
                </div>
                <p>Nom de la mutuelle ou de l'assurance <span>*</span></p>
                <input type="text" name="nomassurance" value="<?php echo isset($_SESSION['nomassurance']) ? $_SESSION['nomassurance'] : ''; ?>" placeholder required minlength="3" pattern="[A-Za-z]+">
                <p>Numéro d'adhérent <span>*</span></p>
                <input type="text" name="numadhérent" value="<?php echo isset($_SESSION['numéro_adhérent']) ? $_SESSION['numéro_adhérent'] : ''; ?>" placeholder required minlength="10" maxlength="10">
                <p>Chambre Particulière ? <span>*</span></p>
                <select name="chambre" id="" required>
                    <option value="">Choix</option>
                    <?php
                        // Vérifier si des résultats sont retournés
                        if ($result->num_rows > 0) {
                            // Afficher chaque identifiant dans le menu déroulant
                            while ($row = $result->fetch_assoc()) {
                                // Créer une valeur concaténée "num_chambre - type_chambre"
                                $chambre_value = $row['num_chambre'] . ' - ' . $row['type_chambre'];
                                echo '<option value="' . $chambre_value . '" ';
                                if (isset($_SESSION['chambre_selection']) && $_SESSION['chambre_selection'] == $chambre_value ) {
                                    echo 'selected'; // Pré-sélectionner la chambre si elle est déjà choisie dans la session
                                }
                                echo '>' . $chambre_value . '</option>'; 
                            }
                        } else {
                            echo '<option value="">Aucun identifiant trouvé</option>';
                        }
                    ?>
                </select>
                <div class="inline-fields">
                <!-- Revenir à la page pré_admission_page_2.php -->
                <input type="submit" name="precedent" value="PRECEDENT" formnovalidate class="form-btn">
                <!-- Passer à la page pré_admission_page_4.php -->
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
