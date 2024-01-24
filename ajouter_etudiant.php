<?php

// Configuration de la connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sitabsence";

// Création d'une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification des erreurs de connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Récupération des données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$cne = $_POST['cne'];
$filiere = $_POST['filiere'];

// Vérification si le CNE existe déjà dans la table "etudiants"
$sql = "SELECT * FROM etudiants WHERE cne = '$cne'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Le CNE existe déjà.";
} else {
    // Insertion des données de l'étudiant dans la table "etudiants"
    $insertSql = "INSERT INTO etudiants (cne, nom, prenom, filiere) VALUES ('$cne', '$nom', '$prenom', '$filiere')";

    if ($conn->query($insertSql) === TRUE) {
        echo "Étudiant ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'étudiant : " . $conn->error;
    }
}

$conn->close();
?>