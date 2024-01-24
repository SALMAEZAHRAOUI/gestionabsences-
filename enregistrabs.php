<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "sitabsence";

$connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);

// Récupération des filières depuis la base de données
$requeteFiliere = $connexion->prepare("SELECT nom FROM  filiere");
$requeteFiliere->execute();
$filieres = $requeteFiliere->fetchAll(PDO::FETCH_COLUMN);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Affichage des étudiants et enregistrement d'absence</title>
    <style>
       

        form {
            margin-bottom: 20px;
        }

   


    </style>
</head>
<body>
<br>

</div>
    <h1>Affichage des étudiants et enregistrement d'absence</h1>

    <form method="POST" action="affichage.php">
        <label for="filiere">Choisir une filière :</label>
        <select name="filiere">
            <?php foreach ($filieres as $filiere) {
                echo "<option value='".$filiere."'>".$filiere."</option>";
            } ?>
        </select>
       

 <input type="submit" value="Afficher">
    </form>
</body>
</html>