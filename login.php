<?php

// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "sitabsence";

$connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérification des informations de connexion du professeur
    // Vérification si le professeur existe dans la base de données
    $sql = "SELECT * FROM professeur WHERE email = :email";
    $requete = $connexion->prepare($sql);
    $requete->bindValue(':email', $email);
    $requete->execute();

    if ($requete->rowCount() > 0) {
        $row = $requete->fetch(PDO::FETCH_ASSOC);
        $hashedPassword = $row['password']; // Récupération du mot de passe haché depuis la base de données

        // Vérification du mot de passe
        if (password_verify($password, $hashedPassword)) {
            echo "hello";

            // Redirection vers la page du professeur
            header("Location: PROFESSEUR.PHP");
            exit();
        } else {
            // Mot de passe incorrect, afficher un message d'erreur
            echo "Mot de passe incorrect.";
        }
    } else {
        // Professeur non trouvé, afficher un message d'erreur
        echo "Professeur non trouvé.";
    }
}
?>