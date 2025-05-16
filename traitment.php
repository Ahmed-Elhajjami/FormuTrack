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

// Vérifier la méthode de la requête
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et sécuriser les données du formulaire
    $partenaire = htmlspecialchars($_POST['partenaire']);
    $nomPresident = htmlspecialchars($_POST['nomPresident']);
    $activite = htmlspecialchars($_POST['activite']);
    $projet = htmlspecialchars($_POST['projet']);
    $budgetDebloque = htmlspecialchars($_POST['budgetDebloque']);
    $avancement = htmlspecialchars($_POST['avancement']);
    $chefDeProjet = htmlspecialchars($_POST['chefDeProjet']);

    // Préparer la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO clients (partenaire, nom_president, activite, projet, budget_debloque, avancement, chef_de_projet) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("sssssss", $partenaire, $nomPresident, $activite, $projet, $budgetDebloque, $avancement, $chefDeProjet);

    // Exécuter la requête
    if ($stmt->execute()) {
        $message = "Nouveau client ajouté avec succès.";
    } else {
        $message = "Erreur : " . $stmt->error;
    }

    // Fermer la déclaration
    $stmt->close();

    // Fermer la connexion
    $conn->close();

    // Inclure le CSS et le JavaScript
    echo '<style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("trait.jpg"); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .container.show {
            opacity: 1;
            transform: translateY(0);
        }
        h1 {
            color: #333;
        }
        p {
            margin: 10px 0;
            font-size: 18px;
            color: #555;
        }
        .button-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .button-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .button-container button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .button-container button:active {
            transform: scale(0.98);
        }
    </style>';

    // Afficher les données soumises
    echo '<div class="container show">';
    echo "<h1>$message</h1>";
    echo "<p>Partenaire : $partenaire</p>";
    echo "<p>Nom président : $nomPresident</p>";
    echo "<p>Activité : $activite</p>";
    echo "<p>Projet : $projet</p>";
    echo "<p>Budget débloqué : $budgetDebloque</p>";
    echo "<p>Avancement : $avancement</p>";
    echo "<p>Chef de projet : $chefDeProjet</p>";

    // Boutons pour ajouter un autre client et afficher les clients
    echo '<div class="button-container">';
    echo '<form action="form.php" method="get">';
    echo '<button type="submit">Ajouter un autre client</button>';
    echo '</form>';

    echo '<form action="infos.php" method="get">';
    echo '<button type="submit">Afficher les clients</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';

    // Ajouter le JavaScript pour l'animation
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector(".container").classList.add("show");
        });
    </script>';
} else {
    echo "Aucune donnée soumise.";
}
?>
