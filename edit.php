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

// Récupérer l'ID du client à éditer
$id = intval($_GET['id']);
$sql = "SELECT * FROM clients WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$client = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Éditer Client</title>
    <link rel="stylesheet" href="traitement.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            background-image: url("laptop.jpg"); /* Remplacez par le chemin de votre image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
        }
        h1 {
            color: #333;
            margin-top: 20px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"] {
            width: calc(100% - 24px);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: #fff;
            background-color: #007bff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        button:active {
            transform: scale(0.98);
        }
        a {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Éditer Client</h1>
    <form id="edit-form" action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($client['id']); ?>">
        
        <label>Partenaire:</label>
        <input type="text" name="partenaire" value="<?php echo htmlspecialchars($client['partenaire']); ?>" required><br>

        <label>Nom Président:</label>
        <input type="text" name="nom_president" value="<?php echo htmlspecialchars($client['nom_president']); ?>" required><br>

        <label>Activité:</label>
        <input type="text" name="activite" value="<?php echo htmlspecialchars($client['activite']); ?>" required><br>

        <label>Projet:</label>
        <input type="text" name="projet" value="<?php echo htmlspecialchars($client['projet']); ?>" required><br>

        <label>Budget Débloqué:</label>
        <input type="number" name="budget_debloque" value="<?php echo htmlspecialchars($client['budget_debloque']); ?>" required><br>

        <label>Avancement:</label>
        <input type="text" name="avancement" value="<?php echo htmlspecialchars($client['avancement']); ?>" required><br>

        <label>Chef de Projet:</label>
        <input type="text" name="chef_de_projet" value="<?php echo htmlspecialchars($client['chef_de_projet']); ?>" required><br>

        <button type="submit">Mettre à jour</button>
    </form>

    <a href="infos.php">Retourner à la liste des clients</a>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Événement lors de la soumission du formulaire
            document.getElementById('edit-form').addEventListener('submit', function(event) {
                // Ajout d'une animation de soumission
                this.querySelector('button').textContent = 'En cours...';
                this.querySelector('button').disabled = true;
            });

            // Effets de survol et focus
            document.querySelectorAll('input').forEach(function(input) {
                input.addEventListener('mouseover', function() {
                    this.style.backgroundColor = '#f7f7f7';
                });
                input.addEventListener('mouseout', function() {
                    this.style.backgroundColor = '#fff';
                });
            });
        });
    </script>
</body>
</html>
