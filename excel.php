<!DOCTYPE html>
<html>
<head>
    <title>Exportation des absences au format Excel</title>
    <style>
    h1 {
  text-align: center;
}
form{
    text-align: center;
}
    </style>
</head>
<body>

    <h1>Exportation des absences au format Excel</h1>

    <form method="POST" action="fichiereexcel.php">
        <label for="filiere">Sélectionnez une filière :</label>
        <select name="filiere" id="filiere">
            <?php
            // Connexion à la base de données
            $serveur = "localhost";
            $utilisateur = "root";
            $motdepasse = "";
            $base_de_donnees = "sitabsence";

            $connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);

            // Récupération des filières disponibles
            $requete_filieres = $connexion->query("SELECT nom FROM  filiere");

            // Affichage des options
            while ($filiere = $requete_filieres->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $filiere['nom'] . "'>" . $filiere['nom'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Exporter au format Excel">
    </form>
</body>
</html>