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

// Query to fetch filières from the table
$query = "SELECT DISTINCT filiere FROM $tbl_name";
$result = mysqli_query($conn, $query);

// Check if there are filières in the table
if (mysqli_num_rows($result) > 0) {
    echo "<form method='post' action='suppet.php'>";
    echo "<label for='filiere'>Sélectionnez une filière :</label>";
    echo "<select name='filiere' id='filiere'>";
    
    // Loop through each filière and display it as an option in the select menu
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='".$row['filiere']."'>".$row['filiere']."</option>";
    }
    
    echo "</select>";
    echo "<input type='submit' value='Supprimer les étudiants'>";
    echo "</form>";
} else {
    echo "Aucune filière trouvée dans la base de données.";
}

// Check if the filiere parameter is present
if (isset($_POST['filiere'])) {
    // Get the selected filiere value from the form
    $filiere = $_POST['filiere'];

    // Query to delete students of the selected filiere from the table
    $query = "DELETE FROM $tbl_name WHERE filiere = '$filiere'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Les étudiants de la filière ".$filiere." ont été supprimés avec succès.";
    } else {
        echo "Erreur lors de la suppression des étudiants de la filière ".$filiere.": " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>