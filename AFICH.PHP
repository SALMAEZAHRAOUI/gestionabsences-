<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "sitabsence";

$connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);

// Enregistrement de l'absence
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['absent'])) {
    $filiere = $_POST['filiere'];
    $element = $_POST['element'];
    $absents = $_POST['absent'];
    $dateAbsence = $_POST['date_absence'];
    $heureAbsence = $_POST['heure_absence'];

    // Boucle sur les étudiants absents
    foreach ($absents as $cne) {
        // Enregistrer l'absence dans la base de données
        $requete_absence = $connexion->prepare("INSERT INTO absence (cne, element, date_absence, heure, nomfiliere) VALUES (?, ?, ?, ?,?)");

        $requete_absence->execute([$cne, $element, $dateAbsence, $heureAbsence, $filiere ]);
    }

    echo "Absences enregistrées avec succès pour la filière $filiere, élément $element.";
}
?>