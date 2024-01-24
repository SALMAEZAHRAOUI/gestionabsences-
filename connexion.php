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

// Récupération des données du formulaire de connexion
$email = $_POST['email'];
$motDePasse = $_POST['motDePasse'];
session_start();

// Récupérer l'e-mail de l'étudiant connecté
$_SESSION['email']=$email;


// Vérification si l'utilisateur existe dans la base de données
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashMotDePasse = $row['password'];
    $isAdmin = $row['isAdmin'];

    if (password_verify($motDePasse, $hashMotDePasse)) {
        if ($isAdmin == 2) {
            header("Location: ADMIN.php"); // Redirection vers la page ADMIN.php
            exit();
        } else {
            header("Location: etudiant.php"); // Redirection vers la page etudiant.php
            exit();
        }
    } else {
        echo "Mot de passe incorrect.";
    }
} else {
    echo "Utilisateur non trouvé.";
}

$conn->close();
?>