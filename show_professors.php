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

    // Query to delete the professor from the table
    $query = "DELETE FROM $tbl_name WHERE id_prof = '$id_prof'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Professeur supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du professeur : " . mysqli_error($conn);
    }
}

// Query to fetch professors from the table
$query = "SELECT * FROM $tbl_name";
$result = mysqli_query($conn, $query);

// Check if there are professors in the table
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Email</th><th>Nom</th><th>Action</th></tr>";

    // Loop through each professor and display their information
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['id_prof']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['nom']."</td>";
        echo "<td><form method='post' action='supp.php'>";
        echo "<input type='hidden' name='id_prof' value='".$row['id_prof']."'>";
        echo "<input type='submit' value='Supprimer'></form></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Aucun professeur trouvé dans la base de données.";
}

mysqli_close($conn);
?>