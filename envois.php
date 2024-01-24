<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "sitabsence";

$connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom_element = $_POST['nom_element'];
    $filiere_id = $_POST['nom_Filiere'];
    $prof_id = $_POST['nom_prof'];

    // Insérer l'élément dans la table "matiere_filiere"
    $requete_insertion = $connexion->prepare("INSERT INTO matiere_filiere (element, filiere_id, id_prof) VALUES (?, ?, ?)");
    $requete_insertion->execute([$nom_element, $filiere_id, $prof_id]);

    echo "L'élément a été ajouté avec succès.";
}
?>