<style>
  .container {
  text-align: center;
   background-color: #f2F2f2;
 height: 70px;
}
.nav ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.nav li {
  display: inline-block;
  margin-right: 10px;
}

.nav li a {
  text-decoration: none;
  color: black;
}
.nav a:hover {
  background-color: palevioletred;
  color: #fff;
}
h1 {
  text-align: center;
}
</style>
<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "sitabsence";

$connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);

// Vérifier si la filière a été sélectionnée dans le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filiere'])) {
    $filiere = $_POST['filiere'];

    // Récupérer la liste des étudiants de la filière
    $requete_etudiants = $connexion->prepare("SELECT * FROM etudiants WHERE filiere = ?");
    $requete_etudiants->execute([$filiere]);
    $etudiants = $requete_etudiants->fetchAll(PDO::FETCH_ASSOC);

    // Afficher la liste des étudiants

    // Afficher le formulaire d'enregistrement d'absence
    echo "<h2>Enregistrer une absence pour la filière $filiere</h2>";
    echo "<form method='POST' action='AFICH.PHP'>";
    echo "<input type='hidden' name='filiere' value='$filiere'>";

    // Récupérer la liste des éléments de la filière
    $requete_elements = $connexion->prepare("
        SELECT DISTINCT mf.element
        FROM matiere_filiere mf
        INNER JOIN filiere f ON mf.filiere_id = f.id
        WHERE f.nom = ?");
    $requete_elements->execute([$filiere]);
    $elements = $requete_elements->fetchAll(PDO::FETCH_ASSOC);

    echo "<label for='element'>Élément :</label>";
    echo "<select id='element' name='element'required>";
    foreach ($elements as $element) {
        echo "<option value='{$element['element']}'>{$element['element']}</option>";
    }
    echo "</select><br><br>";

    echo "<label for='date_absence'>Date d'absence :</label>";
    echo "<input type='date' id='date_absence' name='date_absence' required><br><br>";

    echo "<label for='heure_absence'>Heure d'absence :</label>";
    echo "<input type='time' id='heure_absence' name='heure_absence'required><br><br>";

    echo "<label for='absents'> coucher les Étudiants absents :</label><br><br>";
    foreach ($etudiants as $etudiant) {
        echo "<input type='checkbox' name='absent[]' value='{$etudiant['cne']}' id='{$etudiant['cne']}'>";
        echo "<label for='{$etudiant['cne']}'>{$etudiant['nom']} {$etudiant['prenom']}</label><br>";
    }
    echo "<br>";

    echo "<input type='submit' value='Enregistrer'>";
    echo "</form>";
}
?><style>
  body{
    text-align: center;
    background-color: #f2f2f2;
    height: 70px;
  }


  h1 {
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

  input[type="text"],
  input[type="date"],
  input[type="time"],
  select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin-bottom: 15px;
  }

  input[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
  }

  input[type="submit"]:hover {
    background-color: #45a049;
  }
</style>