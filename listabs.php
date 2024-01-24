<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "sitabsence";

$connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);

// Récupérer la liste des filières depuis la base de données
$requete_filieres = $connexion->query("SELECT * FROM filiere");
$filieres = $requete_filieres->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si la filière a été sélectionnée dans le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filiere'])) {
    $filiere = $_POST['filiere'];

    // Récupérer la liste des étudiants de la filière
    $requete_etudiants = $connexion->prepare("SELECT * FROM etudiants WHERE filiere = ?");
    $requete_etudiants->execute([$filiere]);
    $etudiants = $requete_etudiants->fetchAll(PDO::FETCH_ASSOC);

    // Afficher la liste des étudiants et leur total d'absences dans un tableau
    echo "<h2>Liste des étudiants de la filière $filiere</h2>";
    echo "<table>";
    echo "<tr><th>Nom</th><th>Prénom</th><th>Élément</th><th>Total d'absences</th></tr>";

    foreach ($etudiants as $etudiant) {
        $cne = $etudiant['cne'];
        $requete_absences = $connexion->prepare("
            SELECT COUNT(*) AS total_absences
            FROM absence
            WHERE cne = ? AND nomfiliere = ?");
        $requete_absences->execute([$cne, $filiere]);
        $absences = $requete_absences->fetch(PDO::FETCH_ASSOC);

        echo "<tr>";
        echo "<td>{$etudiant['nom']}</td>";
        echo "<td>{$etudiant['prenom']}</td>";
        echo "<td>{$etudiant['element']}</td>";
        echo "<td>{$absences['total_absences']}</td>";
        echo "</tr>";
    }

    echo "</table>";
}

// Afficher le formulaire de sélection de filière
echo "<h2>Sélectionner une filière :</h2>";
echo "<form method='POST' action='afficher_absences.php'>";
echo "<label for='filiere'>Filière :</label>";
echo "<select id='filiere' name='filiere' required>";
foreach ($filieres as $filiere) {
    echo "<option value='{$filiere['nom']}'>{$filiere['nom']}</option>";
}
echo "</select><br><br>";
echo "<input type='submit' value='Afficher'>";
echo "</form>";
?>