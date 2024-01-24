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

// Requête de vérification du CNE
$cne = $_POST['cne'];
$query = "SELECT * FROM etudiants WHERE cne = ?";
$statement = $conn->prepare($query);
$statement->bind_param("s", $cne);
$statement->execute();
$result = $statement->get_result();

// Vérifier si le résultat est vide
if ($result->num_rows === 0) {
    echo "Le CNE n'existe pas dans la table des étudiants.";
} else {
// Récupération des données du formulaire d'enregistrement
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$email = $_POST['email'];
$motDePasse = $_POST['motDePasse'];
$contactNo = $_POST['contactNo'];
$cne = $_POST['cne'];

// Vérification si l'utilisateur existe déjà dans la base de données
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Cet email est déjà utilisé. Veuillez utiliser une autre adresse email.";
} else {
    // Hashage du mot de passe avant de l'enregistrer dans la base de données
    $hashMotDePasse = password_hash($motDePasse, PASSWORD_DEFAULT);

    // Insertion des informations de l'utilisateur dans la base de données
    $sql = "INSERT INTO users (first_name, last_name, email, password, contact_no, cne) 
            VALUES ('$prenom', '$nom', '$email', '$hashMotDePasse', '$contactNo', '$cne')";

    if ($conn->query($sql) === TRUE) {
        echo "Utilisateur enregistré avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement de l'utilisateur : " . $conn->error;
    }
}}

?>