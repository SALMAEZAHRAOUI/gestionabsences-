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

// Query to fetch users with isAdmin equal to 2 from the table
$query = "SELECT * FROM $tbl_name WHERE isAdmin = 2";
$result = mysqli_query($conn, $query);

// Check if there are users in the table
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Action</th></tr>";
    
    // Loop through each user and display their information
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['first_name']."</td>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td><form method='post' action='supa.php'>";
        echo "<input type='hidden' name='email' value='".$row['email']."'>";
        echo "<input type='submit' value='Supprimer'></form></td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "Aucun administrateur trouvé dans la base de données.";
}

mysqli_close($conn);
?>