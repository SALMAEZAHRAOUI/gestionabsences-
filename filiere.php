<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $nomFiliere = $_POST["nom_filiere"];
    

    // Effectuer les validations nécessaires sur les données

    // Se connecter à la base de données
    $dsn = "mysql:host=localhost;dbname=sitabsence";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête d'insertion
        $query = "INSERT INTO filiere (nom) VALUES (?)";
        $stmt = $pdo->prepare($query);

        // Exécuter la requête avec les valeurs des paramètres
        $stmt->execute([$nomFiliere]);

        // Rediriger vers une page de succès ou afficher un message de succès
        echo "enregistre avec  succès";
        exit();
    } catch (PDOException $e) {
        // Gérer les erreurs de la base de données
        echo "Erreur : " . $e->getMessage();
    }
}
?>