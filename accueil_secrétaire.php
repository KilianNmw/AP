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

// Requête pour récupérer les identifiants avec id_rôle = 3
$sql = "SELECT identifiant FROM Personnels WHERE id_rôle = 3";
$result = $conn->query($sql);

// Redirection si le bouton "SUIVANT" est cliqué
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["suivant"])) {
    // Sauvegarde des données du formulaire dans la session
    $_SESSION['pre_admission'] = $_POST['pré-ad'];
    $_SESSION['datehospi'] = $_POST['datehospi'];
    $_SESSION['heureinter'] = $_POST['heureinter'];
    $_SESSION['nom_méd'] = $_POST['nom_méd'];

    header("Location: pré_admission_page_2.php"); // Redirige vers la page2
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
        <title>Pré-admission/page1</title>
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
            <p>Pré-admission pour : <span>*</span></p>
            <select name="pré-ad" id="" required>
        <option value="">Choix</option>
        <option value="Ambulatoire chirurgie" <?php echo (isset($_SESSION['pre_admission']) && $_SESSION['pre_admission'] == 'Ambulatoire chirurgie') ? 'selected' : ''; ?>>Ambulatoire chirurgie</option>
        <option value="Hospitalisation (au moins une nuit)" <?php echo (isset($_SESSION['pre_admission']) && $_SESSION['pre_admission'] == 'Hospitalisation (au moins une nuit)') ? 'selected' : ''; ?>>Hospitalisation (au moins une nuit)</option>
    </select>
    <div class="côte_à_côte">
        <div class="éléments">
            <p>Date Hospitalisation : <span>*</span></p>
            <input type="date" name="datehospi" value="<?php echo isset($_SESSION['datehospi']) ? $_SESSION['datehospi'] : ''; ?>" required>
        </div>
        <div class="éléments">
            <p>Heure de l'intervention : <span>*</span></p>
            <input type="time" name="heureinter" value="<?php echo isset($_SESSION['heureinter']) ? $_SESSION['heureinter'] : ''; ?>" required>
        </div>
    </div>
    <p>Nom du médecin : <span>*</span></p>
    <select name="nom_méd" id="" required>
        <option value="">Choix</option>
        <?php
            // Remplir la liste déroulante avec les options
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $selected = (isset($_SESSION['nom_méd']) && $_SESSION['nom_méd'] == $row['identifiant']) ? 'selected' : '';
                    echo '<option value="' . $row['identifiant'] . '" ' . $selected . '>' . $row['identifiant'] . '</option>';
                }
            } else {
                echo '<option value="">Aucun identifiant trouvé</option>';
            }
        ?>
    </select>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <input type="submit" name="suivant" value="SUIVANT" class="form-btn">
</form>
        </div>
        <?php
            // Fermer la connexion
            $conn->close();
        ?>
    </body>
    <script>
        // Empêcher le retour arrière du navigateur
            window.history.pushState(null, '', window.location.href);
            window.onpopstate = function () {
                window.history.pushState(null, '', window.location.href);
            };
    </script>
</html>