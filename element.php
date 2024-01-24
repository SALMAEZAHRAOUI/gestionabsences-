

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un élément</title>
    <style>
        h1 {
            text-align: center;
        }

        form {
            text-align: center;
        }
    </style>
</head>
<body>
<h1>Ajouter un élément</h1>

<form method="POST" action="envois.php">
    <label for="nom_element">Nom de l'élément :</label>
    <input type="text" id="nom_element" name="nom_element" required>

    <label for="nom_Filiere">Filière :</label>
    <select id="nom_Filiere" name="nom_Filiere" required>
        <?php
        // Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "sitabsence";

$connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);
        // Récupération des filières depuis la table "filiere"
        $requete_filiere = "SELECT * FROM filiere";
        $resultat_filiere = $connexion->query($requete_filiere);

        // Affichage des options filière
        while ($row_filiere = $resultat_filiere->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row_filiere['id'] . '">' . $row_filiere['nom'] . '</option>';
        }
        ?>
    </select>

    <label for="nom_prof">Professeur :</label>
    <select id="nom_prof" name="nom_prof" required>
        <?php
        // Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "sitabsence";

$connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);
        // Récupération des enseignants depuis la table "professeur"
        $requete_prof = "SELECT * FROM professeur";
        $resultat_prof = $connexion->query($requete_prof);

        // Affichage des options enseignant
        while ($row_prof = $resultat_prof->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row_prof['id_prof'] . '">' . $row_prof['nom'] . '</option>';
        }
        ?>
    </select>

    <input type="submit" value="Ajouter">
</form>
</body>
</html>