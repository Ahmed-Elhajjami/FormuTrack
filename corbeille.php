<?php
$conn = new mysqli("localhost", "root", "", "formulaire");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$sql = "SELECT * FROM clients WHERE supprime = 1";
$result = $conn->query($sql);

echo '<style>
    body {
        font-family: Arial, sans-serif;
        margin: 30px;
        background-image: url("corbeille.jpeg");
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        color: #333;
    }
    h2 {
        text-align: center;
        color: #fff;
        text-shadow: 1px 1px 3px black;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: rgba(255,255,255,0.95);
    }
    th, td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: left;
    }
    th {
        background-color: #007bff;
        color: white;
    }
    .btn-blue {
        padding: 6px 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin: 2px;
    }
    .btn-blue:hover {
        background-color: #0056b3;
    }
</style>';

echo '<h2>🗑️ Clients dans la corbeille</h2>';

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Partenaire</th>
                <th>Nom Président</th>
                <th>Activité</th>
                <th>Projet</th>
                <th>Chef de Projet</th>
                <th>Actions</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['partenaire']."</td>
                <td>".$row['nom_president']."</td>
                <td>".$row['activite']."</td>
                <td>".$row['projet']."</td>
                <td>".$row['chef_de_projet']."</td>
                <td>
                    <form action='restore.php' method='post' style='display:inline;'>
                        <input type='hidden' name='id' value='".$row['id']."'>
                        <button type='submit' class='btn-blue'>♻️ Restaurer</button>
                    </form>
                    <form action='delete.php' method='post' style='display:inline;'>
                        <input type='hidden' name='id' value='".$row['id']."'>
                        <input type='hidden' name='definitif' value='1'>
                        <button type='submit' class='btn-blue' onclick='return confirm(\"Supprimer définitivement ?\")'>❌ Supprimer définitivement</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align: center; color: black;'>Aucun client dans la corbeille.</p>";

    echo '<div style="text-align: center; margin-top: 30px;">
        <form action="infos.php" method="get">
            <button type="submit" class="btn-blue">⬅️ Retour à la liste des clients</button>
        </form>
      </div>';

}

// Bouton de retour


$conn->close();
?>
