<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$db_name = "sitabsence";
$tbl_name = "etudiants";

$conn = mysqli_connect($host, $username, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the filiere parameter is present
if (isset($_POST['filiere'])) {
    // Get the selected filiere value from the form
    $filiere = $_POST['filiere'];

    // Delete absences of the students in the selected filiere
    $delete_absences_query = "DELETE FROM absence WHERE cne IN (SELECT cne FROM $tbl_name WHERE filiere = '$filiere')";
    $delete_absences_result = mysqli_query($conn, $delete_absences_query);

    if (!$delete_absences_result) {
        echo "Erreur lors de la suppression des absences des étudiants de la filière ".$filiere.": " . mysqli_error($conn);
        mysqli_close($conn);
        exit;
    }

    // Delete students of the selected filiere from the table
    $delete_students_query = "DELETE FROM $tbl_name WHERE filiere = '$filiere'";
    $delete_students_result = mysqli_query($conn, $delete_students_query);

    if ($delete_students_result) {
        echo "Les étudiants de la filière ".$filiere." ont été supprimés avec succès.";
    } else {
        echo "Erreur lors de la suppression des étudiants de la filière ".$filiere.": " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>