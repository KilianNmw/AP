<?php

session_start();

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

// Redirection si le bouton "PRÉCÉDENT" est cliqué
if (isset($_POST['precedent'])) {
    header("Location: pré_admission_page_3.php"); // Redirige vers la page3 de la pré-admission
    exit();
}

// Redirection si le bouton "SUIVANT" est cliqué
if (isset($_POST['submit'])) {
    $_SESSION['carte_identité'] = $_POST['carteidentité'];
    $_SESSION['carte_vitale'] = $_POST['cartevitale'];
    $_SESSION['carte_mutuelle'] = $_POST['cartemutuelle'];
    $_SESSION['livret_famille'] = $_POST['livretfamille'];

    $pré_admission = $_SESSION['pre_admission'];
    $date_hospi = $_SESSION['datehospi'];
    $date_intervention = $_SESSION['heureinter'];
    $nom_médecin = $_SESSION['nom_méd'];

    $civilité = $_SESSION['civilité'];
    $nom_naissance = $_SESSION['nomnaissance'];
    $nom_épouse = $_SESSION['nomépouse'];
    $prénom = $_SESSION['prénom'];
    $date_naissance = $_SESSION['datenaissance'];
    $adresse = $_SESSION['adresse'];
    $code_postal = $_SESSION['code_postal'];
    $ville = $_SESSION['ville'];
    $email = $_SESSION['email'];
    $téléphone = $_SESSION['téléphone'];

    $nom_confiance = $_SESSION['nomconfiance'];
    $prénom_confiance = $_SESSION['prénomconfiance'];
    $téléphone_confiance = $_SESSION['téléphoneconfiance'];
    $adresse_confiance = $_SESSION['adresseconfiance'];

    $nom_contacter = $_SESSION['nomcontacter'];
    $prénom_contacter = $_SESSION['prénomcontacter'];
    $téléphone_contacter = $_SESSION['téléphonecontacter'];
    $adresse_contacter = $_SESSION['adressecontacter'];

    $organisme = $_SESSION['organisme'];
    $num_sécu = $_SESSION['numéro_sécurité_sociale'];
    $assuré = $_SESSION['assuré'];
    $ald = $_SESSION['ald'];
    $nom_assurance = $_SESSION['nomassurance'];
    $numéro_adhérent = $_SESSION['numéro_adhérent'];
    $chambre = $_SESSION['chambre_selection'];

    $carte_id = $_SESSION['carte_identité'];
    $carte_vi = $_SESSION['carte_vitale'];
    $carte_mu = $_SESSION['carte_mutuelle'];
    $livret = $_SESSION['livret_famille'];

    $num_chambre = intval($chambre);
    // $type_chambre = substr($chambre, strlen((string)$num_chambre));

    try {
        $dsn = "mysql:host=$serveur;dbname=$nombdd;charset=utf8";
        $conn = new PDO($dsn, $nomutilisateur, $motdepasse);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Validation des données
        if (empty($nom_confiance) || empty($prénom_confiance) || empty($téléphone_confiance) || empty($adresse_confiance)) {
            throw new Exception("Les informations pour la personne de confiance sont incomplètes.");
        }
    
        if (empty($nom_contacter) || empty($prénom_contacter) || empty($téléphone_contacter) || empty($adresse_contacter)) {
            throw new Exception("Les informations pour la personne à contacter sont incomplètes.");
        }

        if (empty($num_sécu) || empty($organisme) || empty($assuré) || empty($ald) || empty($nom_assurance) || empty($numéro_adhérent)) {
            throw new Exception("Les informations pour la couverture sociale sont incomplètes.");
        }

        if (empty($civilité) || empty($nom_naissance) || empty($prénom) || empty($date_naissance) || empty($adresse) || empty($code_postal) || empty($ville) || empty($email) || empty($téléphone) || empty($carte_id) || empty($carte_mu) || empty($carte_vi) || empty($livret)) {
            throw new Exception("Les informations pour le patient sont incomplètes.");
        }

        if (empty($pré_admission) || empty($date_hospi) || empty($date_intervention) || empty($nom_médecin) || empty($chambre)) {
            throw new Exception("Les informations pour la pré-admission sont incomplètes.");
        }
    
        // Insertion dans la table Personnes_Confiance
        $sql_confiance = "INSERT INTO Personnes_Confiance(nom, prénom, num_tel, adresse) VALUES (?,?,?,?)";
        $stmt_confiance = $conn->prepare($sql_confiance);
        $stmt_confiance->execute([$nom_confiance, $prénom_confiance, $téléphone_confiance, $adresse_confiance]);
        $id_confiance = $conn->lastInsertId();

        // Insertion dans la table Couverture_Sociale
        $sql_prévenir = "INSERT INTO Personnes_Prévenir(nom, prénom, num_tel, adresse) VALUES (?,?,?,?)";
        $stmt_prévenir = $conn->prepare($sql_prévenir);
        $stmt_prévenir->execute([$nom_contacter, $prénom_contacter, $téléphone_contacter, $adresse_contacter]);
        $id_prévenir = $conn->lastInsertId();

        // Insertion dans la table Couverture_Sociale
        $sql_couverture = "INSERT INTO Couverture_Sociale(num_sécu, organisme, assurance, ald, nom_mutuelle, numéro_adhérent) VALUES (?,?,?,?,?,?)";
        $stmt_couverture = $conn->prepare($sql_couverture);
        $stmt_couverture->execute([$num_sécu, $organisme, $assuré, $ald, $nom_assurance, $numéro_adhérent]);

        // Insertion dans la table Patients
        $sql_patients = "INSERT INTO Patients(civilité, nom_naissance, nom_épouse, prénom_patient, date_naissance, adresse, code_postal, ville, email, téléphone, carte_identité, carte_vitale, carte_mutuelle, livret_famille, num_sécu, id_personne1, id_personne2) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt_patients = $conn->prepare($sql_patients);
        $stmt_patients->execute([$civilité, $nom_naissance, $nom_épouse, $prénom, $date_naissance, $adresse, $code_postal, $ville, $email, $téléphone, $carte_id, $carte_mu, $carte_vi, $livret, $num_sécu, $id_confiance, $id_prévenir]);
        $id_patients = $conn->lastInsertId();

        // Sélectionner id du médecin
        $sql_médecin = "SELECT id_personnel FROM Personnels WHERE identifiant = ?";
        $stmt_médecin = $conn->prepare($sql_médecin);
        $stmt_médecin->execute([$nom_médecin]);
        $id_médecin = $stmt_médecin->fetchColumn(); // Récupère la valeur de la colonne id_personnel

        //Sélectionner id de la chambre
        $sql_chambre = "SELECT id_chambre FROM Chambres WHERE num_chambre = ?";
        $stmt_chambre = $conn->prepare($sql_chambre);
        $stmt_chambre->execute([$num_chambre]);
        $id_chambre = $stmt_chambre->fetchColumn(); // Récupère la valeur de la colonne id_chambre

        // Insertion dans la table Hospitalisation
        $sql_hospitalisation = "INSERT INTO Hospitalisations(pré_admission, date_hospitalisation, heure_intervention, chambre, id_med, id_patient) VALUES (?,?,?,?,?,?)";
        $stmt_hospitalisation = $conn->prepare($sql_hospitalisation);
        $stmt_hospitalisation->execute([$pré_admission, $date_hospi, $date_intervention, $id_chambre, $id_médecin, $id_patients]);
    
        session_unset();
        header("Location: accueil_secrétaire.php");
        exit();
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
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
        <title>Pré-admission/page4</title>
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
                <h3>Pièces à joindre</h3>

                <br>
                <div class="côte_à_côte">
                    <div class="éléments">
                        <p>Carte Identité (recto/verso) : </p>
                        <input type="file" name="carteidentité" required>
                    </div>
                    <div class="éléments">
                        <p>Carte Vitale : </p>
                        <input type="file" name="cartevitale" required>
                    </div>
                </div>
                <div class="côte_à_côte">
                    <div class="éléments">
                        <p>Carte de Mutuelle : </p>
                        <input type="file" name="cartemutuelle" required>
                    </div>
                    <div class="éléments">
                        <p>Livret de famille (enfants mineurs) : </p>
                        <input type="file" name="livretfamille" required>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <div class="autre">
                    <li>✔️ une autorisation de soin ou d'opérer signée par les deux représentants légaux</li>
                    <li>✔️ le livret de famille</li>
                    <li>✔️ ou en cas de monoparentalité, la décision du juge</li>
                </div>

                <br>
                <br>
                <div class="inline-fields">
                <!-- Revenir à la page accueil_secrétaire.php -->
                <input type="submit" name="precedent" value="PRECEDENT" formnovalidate class="form-btn">
                <!-- Passer à la page pré_admission_page3.php -->
                <input type="submit" name="submit" value="Valider" class="form-btn">
                </div>
            </form>
        </div>
        <?php
            // Fermer la connexion
            $conn->close();
        ?>
    </body>
</html>