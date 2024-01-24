<?php
// Récupérer la valeur du bouton qui a été cliqué (Accepter ou Refuser)
if (isset($_POST['accepter'])) {
    $validation = "Accepté";
} elseif (isset($_POST['refuser'])) {
    $validation = "Refusé";
}

// Récupérer la valeur de CNE envoyée depuis le formulaire
$cne = $_POST['cne'];

// Obtenir la date et l'heure actuelles
$date = date("Y-m-d H:i:s");

// Enregistrer l'état de validation et la date dans la base de données
$host = "localhost";
$username = "root";
$password = "";
$db_name = "sitabsence";

$conn = mysqli_connect($host, $username, $password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO validation (etat, cne, datee) VALUES ('$validation', '$cne', '$date')";

if (mysqli_query($conn, $sql)) {
    echo "Validation enregistrée avec succès.";
} else {
    echo "Erreur lors de l'enregistrement de la validation : " . mysqli_error($conn);
}

mysqli_close($conn);
?>