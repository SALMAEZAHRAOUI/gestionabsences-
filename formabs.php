<html>
<head>
  <title>Formulaire d'absence</title>
  <style>
    body {
      
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

  
  <form name="absenceForm" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
  <label for="date">Date d'absence :</label>
  <input type="date" name="date" required>

  <label for="motif">Motif d'absence :</label>
  <input type="text" name="motif" required>

  <label for="email">Adresse e-mail :</label>
  <input type="email" name="email" required>

  <label for="heure">Heure :</label>
  <input type="time" name="heure">

  <label for="cne">CNE :</label>
  <input type="text" name="cne" required>

  <label for="nom">Nom :</label>
  <input type="text" name="nom" required>

  <label for="prenom">Prénom :</label>
  <input type="text" name="prenom" required>

  <label for="pdf">Fichier PDF :</label>
  <input type="file" name="pdf">

  <label for="filiere">Filière :</label>
  <select name="filiere">
    <?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sitabsence";
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Récupérer les filières depuis la table "filiere"
    $query = "SELECT id, nom FROM filiere";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $nom = $row['nom'];
        echo "<option value='$nom'>$nom</option>";
      }
    }

    // Fermer la connexion à la base de données
    $conn->close();
    ?>
  </select>
  <br>
  <br>

  <input type="submit" value="Valider">
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
    $dbname = "sitabsence";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Requête de vérification du CNE
    $cne = $_POST['cne'];
    $query = "SELECT * FROM etudiants WHERE cne = ?";
    $statement = $conn->prepare($query);
    $statement->bind_param("s", $cne);
    $statement->execute();
    $result = $statement->get_result();

    // Vérifier si le résultat est vide
    if ($result->num_rows === 0) {
      echo "<script> alert(\"Le CNE n'existe pas.\");</script>";
    } else {
        // Le CNE existe, vous pouvez procéder à l'insertion des données dans la table "absences"

        // Récupérer les valeurs du formulaire
        $date = $_POST['date'];
        $motif = $_POST['motif'];
        $email = $_POST['email'];
        $heure = $_POST['heure'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $pdf = $_FILES['pdf']['name'];
        $pdf_tmp = $_FILES['pdf']['tmp_name'];
        $pdf_path = "uploads/" . $pdf;
        $filiere = $_POST['filiere'];

        move_uploaded_file($pdf_tmp, $pdf_path);

        // Requête d'insertion des données
        $query = "INSERT INTO absences (date_absence, message, email, heure, cne, nom, prenom, pdf, nom_filiere)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $statement = $conn->prepare($query);
        $statement->bind_param("sssssssss", $date, $motif, $email, $heure, $cne, $nom, $prenom, $pdf_path, $filiere);
        if ($statement->execute()) {
            echo "Envoyé avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'enregistrement de l'absence : " . $conn->error;
        }
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>
 
</body>
</html>