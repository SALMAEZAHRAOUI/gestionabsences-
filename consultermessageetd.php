<style>
h1 {
  text-align: center;
}
form{
    text-align: center;
}
</style>
<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$db_name = "sitabsence";

$conn = mysqli_connect($host, $username, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to retrieve data from the "absences" table
$query = "SELECT date_absence, email, heure, message, nom, prenom, cne, pdf FROM absences";
$result = mysqli_query($conn, $query);
//menu 

// Check if query was successful
if (mysqli_num_rows($result) > 0) {
  echo'<h1> les messages des étudiants</h1>';
    echo'<br>';
    echo "<table style='border-collapse: collapse;'>";
    echo "<tr>
            <th style='border: 1px solid black; padding: 5px;'>Date d'absence</th>
            <th style='border: 1px solid black; padding: 5px;'>Email</th>
            <th style='border: 1px solid black; padding: 5px;'>Heure</th>
            <th style='border: 1px solid black; padding: 5px;'>Message</th>
            <th style='border: 1px solid black; padding: 5px;'>Nom</th>
            <th style='border: 1px solid black; padding: 5px;'>Prénom</th>
            <th style='border: 1px solid black; padding: 5px;'>CNE</th>
            <th style='border: 1px solid black; padding: 5px;'>justifier l'absence</th>
            <th style='border: 1px solid black; padding: 5px;'>Validation</th>
          </tr>";
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $date_absence = $row["date_absence"];
        $mail = $row["email"];
        $heure = $row["heure"];
        $message = $row["message"];
        $nom = $row["nom"];
        $prenom = $row["prenom"];
        $cne = $row["cne"];
        $pdf = $row["pdf"];

        echo "<tr>";
        echo "<td style='border: 1px solid black; padding: 5px;'>" . $date_absence . "</td>";
        echo "<td style='border: 1px solid black; padding: 5px;'><a href='mailto:" . $mail . "'>" . $mail . "</a></td>";
        echo "<td style='border: 1px solid black; padding: 5px;'>" . $heure . "</td>";
        echo "<td style='border: 1px solid black; padding: 5px;'>" . $message . "</td>";
        echo "<td style='border: 1px solid black; padding: 5px;'>" . $nom . "</td>";
        echo "<td style='border: 1px solid black; padding: 5px;'>" . $prenom . "</td>";
        echo "<td style='border: 1px solid black; padding: 5px;'>" . $cne . "</td>";
        echo "<td style='border: 1px solid black; padding: 5px;'><a href='" . $pdf . "'>Voir le PDF</a></td>";
        echo "<td style='border: 1px solid black; padding: 5px;'>
                <form method='POST' action='valdation.php'>
                  <input type='hidden' name='cne' value='" . $cne . "'>
                  <input style='' type='submit' name='accepter' value='Accepter'>
                  <input type='submit' name='refuser' value='Refuser'>
                </form>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

mysqli_close($conn);
?>><style>
table {
    border-collapse: collapse;
    width: 80%;
}

th, td {
    padding: 8px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
}






</style>