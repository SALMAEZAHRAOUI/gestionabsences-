<?php
// Inclure la bibliothèque PhpOffice/PhpSpreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "sitabsence";

$connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si un fichier a été soumis par l'utilisateur
    if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
        $chemin_fichier_excel = $_FILES['excelFile']['tmp_name'];

        // Charger le fichier Excel
        $feuille = IOFactory::load($chemin_fichier_excel)->getActiveSheet();

        // Récupérer les données du fichier Excel
        $donnees = $feuille->toArray(null, true, true, true);

        // Préparer la requête d'insertion
        $requete_insertion = $connexion->prepare("INSERT INTO etudiants (cne, nom, prenom, filiere) VALUES (?, ?, ?, ?)");

        // Parcourir les données du fichier Excel
        foreach ($donnees as $ligne) {
            $cne = $ligne['A'];
            $nom = $ligne['B'];
            $prenom = $ligne['C'];
            $filiere = $_POST['filiere'];

            // Vérifier si l'étudiant avec le même CNE existe déjà dans la base de données
            $requete_verifier_existence = $connexion->prepare("SELECT cne FROM etudiants WHERE cne = ?");
            $requete_verifier_existence->execute([$cne]);
            $resultat = $requete_verifier_existence->fetch(PDO::FETCH_ASSOC);

            if ($resultat) {
                echo "L'étudiant avec le CNE $cne existe déjà.<br>";
            } else {
                // Exécuter la requête d'insertion
                $requete_insertion->execute([$cne, $nom, $prenom, $filiere]);
                echo "Données insérées avec succès pour l'étudiant avec le CNE $cne.<br>";
            }
        }
    } else {
        echo "Veuillez sélectionner un fichier Excel.";
    }
}
?>