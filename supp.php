<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$db_name = "sitabsence";
$tbl_name = "professeur";

$conn = mysqli_connect($host, $username, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the id_prof parameter is present
if (isset($_POST['id_prof'])) {
    // Get the id_prof value from the form
    $id_prof = $_POST['id_prof'];

    // Query to delete the related records in matiere_filiere table
    $query_delete_matiere_filiere = "DELETE FROM matiere_filiere WHERE id_prof = '$id_prof'";
    $result_delete_matiere_filiere = mysqli_query($conn, $query_delete_matiere_filiere);

    if ($result_delete_matiere_filiere) {
        // Query to delete the professor from the table
        $query_delete_professeur = "DELETE FROM $tbl_name WHERE id_prof = '$id_prof'";
        $result_delete_professeur = mysqli_query($conn, $query_delete_professeur);

        if ($result_delete_professeur) {
            echo "Professeur supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du professeur : " . mysqli_error($conn);
        }
    } else {
        echo "Erreur lors de la suppression des enregistrements liés dans la table matiere_filiere : " . mysqli_error($conn);
    }
}
?>