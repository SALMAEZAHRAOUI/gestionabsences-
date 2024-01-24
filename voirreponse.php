<style>
.menu {
    list-style-type: none;
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.menu li {
    margin: 0 10px;
}

.menu li a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
}

.menu li a:hover {
    color: #f2f2f2;
}
</style>

<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'étudiant
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo "Accès non autorisé";
    exit();
}

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

// Requête pour récupérer l'état de validation pour l'étudiant connecté
$query = "SELECT etat FROM $tbl_name WHERE cne IN (SELECT cne FROM userss WHERE email='$email')";
$result = mysqli_query($conn, $query);

// Vérifier si la requête a réussi
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $etat = $row['etat'];



    // Afficher l'état de validation à l'étudiant
    echo "<p class='etat-gestion-absence'>Justification d'absence : $etat</p>";
} else {
    echo "Aucune réponse de validation trouvée.";
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?><!DOCTYPE html>
<html>
<head>
  <title>Formulaire d'absence</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 20px;
    }

    h1 {
      color: #333;
      text-align: center;
    }

    form {
      max-width: 400px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }

    input[type="date"],
    input[type="text"],
    input[type="email"],
    input[type="time"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 14px;
      margin-bottom: 15px;
    }

    input[type="file"] {
      margin-bottom: 15px;
    }

    input[type="submit"] {
      background-color: #4caf50;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    input[type="submit"]:focus {
      outline: none;
    }
  </style>
</head>
<body>
  <h1>Formulaire d'absence</h1>

  <form name="absenceForm" onsubmit="return validateForm()" method="post" enctype="multipart/form-data">
    <label for="date">Date d'absence :</label>
    <input type="date" id="date" name="date" required><br><br>

    <label for="motif">Motif :</label>
    <input type="text" id="motif" name="motif" required><br><br>

    <label for="email">Adresse e-mail :</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="heure">Heure :</label>
    <input type="time" id="heure" name="heure" required><br><br>

    <label for="cne">CNE de l'étudiant :</label>
    <input type="text" id="cne" name="cne" required><br><br>

    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required><br><br>

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" required><br><br>

    <label for="pdf">Fichier PDF :</label>
    <input type="file" id="pdf" name="pdf" accept="application/pdf" required><br><br>

    <input type="submit" value="Soumettre">
  </form>

  <script>
    function validateForm() {
      var date = document.forms["absenceForm"]["date"].value;
      var motif = document.forms["absenceForm"]["motif"].value;
      var email = document.forms["absenceForm"]["email"].value;
      var cne = document.forms["absenceForm"]["cne"].value;

      if (date === "") {
        alert("Veuillez saisir la date d'absence.");
        return false;
      }

      if (motif === "") {
        alert("Veuillez saisir le motif de l'absence.");
        return false;
      }

      if (email === "") {
        alert("Veuillez saisir votre adresse e-mail.");
        return false;
      }

      if (cne === "") {
        alert("Veuillez saisir le CNE de l'étudiant.");
        return false;
      }

      alert("Le formulaire a été soumis avec succès !");
      return true;
    }
  </script>

  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Connexion à la base de données
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "absence";

      $conn = new mysqli($servername, $username, $password, $dbname) ;


      if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
      }

      // Récupérer les valeurs du formulaire
      $date = $_POST['date'];
      $motif = $_POST['motif'];
      $email = $_POST['email'];
      $heure = $_POST['heure'];
      $cne = $_POST['cne'];
      $nom = $_POST['nom'];
      $prenom = $_POST['prenom'];

      // Gérer le fichier PDF
      $pdf = $_FILES['pdf']['name'];
      $pdf_tmp = $_FILES['pdf']['tmp_name'];
      $pdf_path = "uploads/" . $pdf;

      move_uploaded_file($pdf_tmp, $pdf_path);

      // Préparer la requête SQL d'insertion avec la clé étrangère cne
      $sql = "INSERT INTO absences (date_absence, message, email, heure, cne, nom, prenom, pdf) 
              VALUES ('$date', '$motif', '$email', '$heure', '$cne', '$nom', '$prenom', '$pdf_path')";

      if ($conn->query($sql) === TRUE) {
        echo "envoyer  avec succès.";
      } else {
        echo "Une erreur s'est produite lors de l'enregistrement de l'absence : " . $conn->error;
      }

      // Fermer la connexion à la base de données
      $conn->close();
    }
  ?>
 
</body>
</html>