<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base_de_donnees = "sitabsence";

$connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);

// Récupération de la filière sélectionnée
$filiere = $_POST['filiere'];

// Requête SQL pour récupérer les données d'absence avec l'élément correspondant
$requete = "SELECT etudiants.nom, etudiants.prenom, etudiants.cne, absence.element, absence.date_absence, absence.heure
            FROM etudiants
            INNER JOIN absence ON etudiants.cne = absence.cne
            WHERE etudiants.filiere = :filiere";
$statement = $connexion->prepare($requete);
$statement->bindParam(':filiere', $filiere);
$statement->execute();
$donnees = $statement->fetchAll(PDO::FETCH_ASSOC);

// Création du classeur Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// En-têtes des colonnes
$sheet->setCellValue('A1', 'Nom');
$sheet->setCellValue('B1', 'Prénom');
$sheet->setCellValue('C1', 'CNE');
$sheet->setCellValue('D1', 'Élément');
$sheet->setCellValue('E1', 'Date d\'absence');
$sheet->setCellValue('F1', 'Heure');

// Remplissage des données
$row = 2;
foreach ($donnees as $donnee) {
    $sheet->setCellValue('A' . $row, $donnee['nom']);
    $sheet->setCellValue('B' . $row, $donnee['prenom']);
    $sheet->setCellValue('C' . $row, $donnee['cne']);
    $sheet->setCellValue('D' . $row, $donnee['element']);
    $sheet->setCellValue('E' . $row, $donnee['date_absence']);
    $sheet->setCellValue('F' . $row, $donnee['heure']);
    $row++;
}

// Enregistrement du fichier Excel
$writer = new Xlsx($spreadsheet);
$nom_fichier = 'absences_' . $filiere . '.xlsx';
$writer->save($nom_fichier);

// Configuration de l'en-tête HTTP pour télécharger le fichier Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nom_fichier . '"');
header('Cache-Control: max-age=0');

// Envoi du fichier Excel au navigateur
$writer->save('php://output');
exit;
?>