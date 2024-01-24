<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "sitabsence";

$connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);

// Récupérer l'email de l'étudiant connecté à partir de la session
session_start(); // Assurez-vous que la session est démarrée
$email = $_SESSION['email'];

// Récupérer l'identifiant de l'étudiant connecté en fonction de son email
$requete_id_etudiant = $connexion->prepare("SELECT cne FROM users WHERE email = ?");
$requete_id_etudiant->execute([$email]);
$cne = $requete_id_etudiant->fetchColumn();

// Récupérer les absences de l'étudiant connecté
$requete_absences_etudiant = $connexion->prepare("SELECT * FROM absence WHERE cne = ?");
$requete_absences_etudiant->execute([$cne]);
$absences_etudiant = $requete_absences_etudiant->fetchAll(PDO::FETCH_ASSOC);
?>

<table>
    <thead>
        <tr>
            <th>Étudiant CNE</th>
            <th>Élément</th>
            <th>Date d'absence</th>
            <th>Heure d'absence</th>
            <th>Filière</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($absences_etudiant as $absence) : ?>
            <tr>
                <td><?php echo $absence['cne']; ?></td>
                <td><?php echo $absence['element']; ?></td>
                <td><?php echo $absence['date_absence']; ?></td>
                <td><?php echo $absence['heure']; ?></td>
                <td><?php echo $absence['nomfiliere']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<style>
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




.total-column {
    font-weight: bold;
}
</style>