<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "sitabsence";

$connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer la filière sélectionnée
    $filiere = $_POST['filiere'];

    // Récupérer la liste des étudiants de la filière
    $requete_etudiants = $connexion->prepare("SELECT * FROM etudiants WHERE filiere = ?");
    $requete_etudiants->execute([$filiere]);
    $etudiants = $requete_etudiants->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer la liste des éléments de la filière depuis la base de données
    $requete_elements = $connexion->prepare("
        SELECT DISTINCT mf.element
        FROM matiere_filiere mf
        INNER JOIN filiere f ON mf.filiere_id = f.id
        WHERE f.nom = ?");
    $requete_elements->execute([$filiere]);
    $elements = $requete_elements->fetchAll(PDO::FETCH_ASSOC);

    // Créer un tableau pour stocker les absences par élément pour chaque étudiant
    $absences_par_element = array();

    foreach ($etudiants as $etudiant) {
        $cne = $etudiant['cne'];
        $absences_par_element[$cne] = array();

        foreach ($elements as $element) {
            $element_nom = $element['element'];
            $requete_absences = $connexion->prepare("
                SELECT COUNT(*) AS total_absences
                FROM absence
                WHERE cne = ? AND nomfiliere = ? AND element = ?");
            $requete_absences->execute([$cne, $filiere, $element_nom]);
            $absences = $requete_absences->fetch(PDO::FETCH_ASSOC);

            $absences_par_element[$cne][$element_nom] = $absences['total_absences'];
        }
    }

    // Afficher le tableau d'absences
    echo "<h2>Absences des étudiants de la filière $filiere</h2>";
    echo "<table>";
    echo "<tr>";
    echo "<th>CNE</th>";
    echo "<th>Nom</th>";
    echo "<th>Prénom</th>";

    foreach ($elements as $element) {
        echo "<th>{$element['element']}</th>";
    }

    echo "<th>Total</th>";

    echo "</tr>";

    foreach ($etudiants as $etudiant) {
        $cne = $etudiant['cne'];
        $nom = $etudiant['nom'];
        $prenom = $etudiant['prenom'];

        echo "<tr>";
        echo "<td>$cne</td>";
        echo "<td>$nom</td>";
        echo "<td>$prenom</td>";

        $total_absences_etudiant = 0;

        foreach ($elements as $element) {
            $element_nom = $element['element'];
            $total_absences = $absences_par_element[$cne][$element_nom];
            echo "<td>$total_absences</td>";
            $total_absences_etudiant += $total_absences;
        }

        echo "<td>$total_absences_etudiant</td>";

        echo "</tr>";
    }

    echo "</table>";
}
?><style>
table {
    border-collapse: collapse;
    width: 80%;
}

th, td {
    padding: 8px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
}



 tr:hover {
    background-color:  #45a049;
    color: #fff;
}

.total-column {
    font-weight: bold;
}
</style>