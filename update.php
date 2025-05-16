<?php
// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "formulaire";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$id = intval($_POST['id']);
$partenaire = $conn->real_escape_string($_POST['partenaire']);
$nom_president = $conn->real_escape_string($_POST['nom_president']);
$activite = $conn->real_escape_string($_POST['activite']);
$projet = $conn->real_escape_string($_POST['projet']);
$budget_debloque = floatval($_POST['budget_debloque']);
$avancement = $conn->real_escape_string($_POST['avancement']);
$chef_de_projet = $conn->real_escape_string($_POST['chef_de_projet']);

// Préparer la requête pour mettre à jour les données
$sql = "UPDATE clients SET 
    partenaire = ?, 
    nom_president = ?, 
    activite = ?, 
    projet = ?, 
    budget_debloque = ?, 
    avancement = ?, 
    chef_de_projet = ? 
    WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssi", $partenaire, $nom_president, $activite, $projet, $budget_debloque, $avancement, $chef_de_projet, $id);

// Exécuter la requête
if ($stmt->execute()) {
    echo "Les informations ont été mises à jour avec succès.";
} else {
    echo "Erreur lors de la mise à jour : " . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirection vers la liste des clients après la mise à jour
header("Location: infos.php");
exit;
?>
