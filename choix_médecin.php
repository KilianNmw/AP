<?php
            $nom_serveur = "localhost";
            $utilisateur = "root";
            $mot_de_passe = "sio2024";
            $nom_base_données = "LPFS_Clinique";
            $con = mysqli_connect($nom_serveur, $utilisateur, $mot_de_passe, $nom_base_données);
            
            // Vérifiez la connexion
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $req = mysqli_query($con, "SELECT identifiant FROM Personnels WHERE id_rôle = '3'");
            $num_ligne = mysqli_num_rows($req);
?>