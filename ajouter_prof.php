<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "sitabsence";

$connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);

// Récupération des données du formulaire
$nom = $_POST['nom'];
$email = $_POST['email'];
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
// Requête pour insérer le professeur dans la base de données
$requete = $connexion->prepare("INSERT INTO professeur (nom, email, password) VALUES (?, ?, ?)");
$requete->execute([$nom, $email, $hashedPassword]);

// Vérification de la réussite de l'insertion
if ($requete) {
  echo "Le professeur a été ajouté avec succès.";
} else {
  echo "Une erreur s'est produite lors de l'ajout du professeur.";
}
?>