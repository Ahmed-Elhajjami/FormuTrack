<?php
$conn = new mysqli("localhost", "root", "", "formulaire");
if ($conn->connect_error) {
    die("Erreur : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    $sql = "UPDATE clients SET supprime = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: corbeille.php");
        exit;
    } else {
        echo "Erreur restauration : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
