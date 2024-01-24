<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un étudiant</title>
    <style>
        /* Appliquer une marge autour du formulaire */
form {
    margin: 20px auto;
  max-width: 400px;
}

/* Styliser les titres */
h2 {
  color: #333;
  font-size: 24px;
}

/* Styliser les libellés des champs */
label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

/* Styliser les champs de saisie */
input[type="text"],
select {
  width: 250px;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 3px;
  margin-bottom: 10px;
}

/* Styliser le bouton Ajouter */
input[type="submit"] {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

/* Changer la couleur du bouton au survol */
input[type="submit"]:hover {
  background-color: #45a049;
}
h2{
  text-align: center;
}
    </style>
</head>
<body>
    <h2>Ajouter un étudiant</h2>
    <form action="ajouter_etudiant.php" method="POST">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" required><br>

        <label for="cne">CNE :</label>
        <input type="text" name="cne" required><br>

        <label for="filiere">Filière :</label>
        <select name="filiere" required>
            <?php
            // Configuration de la connexion à la base de données
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "sitabsence";

            // Création d'une connexion à la base de données
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérification des erreurs de connexion
            if ($conn->connect_error) {
                die("Erreur de connexion à la base de données : " . $conn->connect_error);
            }

            // Récupération des filières depuis la table "filiere"
            $sql = "SELECT * FROM filiere";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $nomFiliere = $row['nom'];
                    echo "<option value='$nomFiliere'>$nomFiliere</option>";
                }
            } else {
                echo "<option>Aucune filière disponible</option>";
            }

            $conn->close();
            ?>
        </select><br>

        <input type="submit" value="Ajouter">
    </form>
</body>
</html>