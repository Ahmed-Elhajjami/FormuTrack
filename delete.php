<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "formulaire";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $definitif = isset($_POST['definitif']) ? intval($_POST['definitif']) : 0;

    if ($definitif === 1) {
        // Suppression définitive
        $sql = "DELETE FROM clients WHERE id = ?";
    } else {
        // Suppression logique (mise à la corbeille)
        $sql = "UPDATE clients SET supprime = 1 WHERE id = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // redirection vers la bonne page selon le type
        $redirect = ($definitif === 1) ? "corbeille.php" : "infos.php";
        header("Location: $redirect");
        exit;
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Aucun ID fourni.";
}

$conn->close();
?>
