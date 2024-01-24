<!DOCTYPE html>
<html>
<head>
    <title>Importation d'étudiants depuis Excel</title>
    <style>
        /* Styles CSS pour le formulaire */
        form {
            margin: 20px auto;
            max-width: 400px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Importation d'étudiants depuis Excel</h2>
    <form action="importer_etudiants.php" method="POST" enctype="multipart/form-data">
        <label for="excelFile">Fichier Excel :</label>
        <input type="file" name="excelFile" required><br><br>
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
        </select><br><br>
        <input type="submit" value="Importer">
    </form>
</body>
</html>