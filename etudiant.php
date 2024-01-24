<?php
session_start();

// Récupérer l'e-mail de l'étudiant connecté
$email = $_SESSION['email'];

// Connexion à la base de données
$host = "localhost";
$username = "root";
$password = "";
$db_name = "sitabsence";
$tbl_name = "validation";

$conn = mysqli_connect($host, $username, $password, $db_name);

// Vérifier la connexion à la base de données
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo"<br>";
echo"<ul>";

echo '<li> <a href="voirabs.php">Consulter absence</a></li>';
echo '<li> <a href="formabs.php">Formulaire d\'absence</a></li>';
echo"</ul>";
// Requête pour récupérer l'état de validation et l'heure de validation pour l'étudiant connecté
$query = "SELECT etat, datee FROM $tbl_name WHERE cne IN (SELECT cne FROM users WHERE email='$email')";
$result = mysqli_query($conn, $query);

// Vérifier si la requête a réussi
if ($result && mysqli_num_rows($result) > 0) {
    echo "<ul class='menu'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $etat = $row['etat'];
        $date = $row['datee'];
        echo "<li> Etat de Validation de message envoyer : $etat | date de validation : $date</li>";
    }
    echo "</ul>";
    echo "mesage bien reçu";
} else {
    echo "Aucune réponse de validation trouvée.";
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>
 <style>
    /* Style CSS pour la mise en forme de la page */
    

    h1 {
        color: #333;
    }


 

     ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    li {
        background-color:  #4CAF50;
        color: #f2f2f2;
       
  margin: 0 10px;
  padding: 10px;
}
    

     li a {
        display: block;
        padding: 10px 20px;
        text-decoration: none;
        color: #f2f2f2;
        font-weight: bold;
    }

      ul li:hover {
        background-color:green;
        color: #fff;
    }

   

    

    



 ul {
  margin: 0;
  padding: 0;
  list-style-type: none;
  display: flex;
  justify-content: center;
}





 
    </style>

