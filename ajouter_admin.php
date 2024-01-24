<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $contactNo = $_POST["contact_no"];
  

    // Hacher le mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Se connecter à la base de données
    $dsn = "mysql:host=localhost;dbname=sitabsence";
    $username = "root";
    $passwordDB = "";

    try {
        $pdo = new PDO($dsn, $username, $passwordDB);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête d'insertion
        $query = "INSERT INTO users (first_name, last_name, email, password, contact_no, registered_at, isAdmin) 
                  VALUES (?, ?, ?, ?, ?, current_timestamp(), 2)";
        $stmt = $pdo->prepare($query);

        // Exécuter la requête avec les valeurs des paramètres
        $stmt->execute([$firstName, $lastName, $email, $hashedPassword, $contactNo]);

        // Rediriger vers une page de succès ou afficher un message de succès
        echo "Admin ajouté avec succès";
        exit();
    } catch (PDOException $e) {
        // Gérer les erreurs de la base de données
        echo "Erreur : " . $e->getMessage();
    }
}
?>