<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$db_name = "sitabsence";
$tbl_name = "users";

$conn = mysqli_connect($host, $username, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the email parameter is present
if (isset($_POST['email'])) {
    // Get the email value from the form
    $email = $_POST['email'];

    // Query to delete the user from the table
    $query = "DELETE FROM $tbl_name WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Utilisateur supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'utilisateur : " . mysqli_error($conn);
    }
}