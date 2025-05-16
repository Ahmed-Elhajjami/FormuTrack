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

// Initialiser les variables de recherche et de tri
$search = '';
$activity_filter = '';

// Vérifier si une recherche a été effectuée
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Vérifier si une activité a été sélectionnée pour le tri
if (isset($_GET['activity'])) {
    $activity_filter = $_GET['activity'];
}

// Définir le nombre de résultats par page
$results_per_page = 5; // Changer le nombre de résultats par page à 5

// Trouver le numéro de la page actuelle
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculer l'offset de la requête
$offset = ($page - 1) * $results_per_page;

// Construire la requête SQL avec filtre et pagination
$sql = "SELECT * FROM clients WHERE supprime = 0 AND chef_de_projet LIKE '%$search%'";
if (!empty($activity_filter)) {
    $sql .= " AND activite = '$activity_filter'";
}
$sql .= " LIMIT $offset, $results_per_page";
$result = $conn->query($sql);

// Afficher les erreurs de requête
if (!$result) {
    die("Erreur lors de la récupération des données : " . $conn->error);
}

// Trouver le nombre total de résultats
$total_sql = "SELECT COUNT(*) FROM clients WHERE supprime = 0 AND chef_de_projet LIKE '%$search%'";
if (!empty($activity_filter)) {
    $total_sql .= " AND activite = '$activity_filter'";
}
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_row();
$total_results = $total_row[0];
$total_pages = ceil($total_results / $results_per_page);

// Récupérer la liste des activités pour le menu déroulant
$activities_sql = "SELECT DISTINCT activite FROM clients";
$activities_result = $conn->query($activities_sql);

// Lien vers le CSS pour le style
echo '<style>
    body {
        font-family: Arial, sans-serif;
        background-image: url("infos.jpg"); 
        background-size: cover;
        margin: 20px;
        color: #333;
        position: relative;
    }
    h1 {
        text-align: center;
        color: black;
    }
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .search-container {
        text-align: center;
        margin-bottom: 20px;
    }
    .search-container input[type="text"], .search-container select {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 300px;
        margin-right: 10px;
    }
    .search-container button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .search-container button:hover {
        background-color: #0056b3;
    }
    .table-container {
        overflow-x: auto;
        margin-top: 20px;
        max-width: 80%;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    th, td {
        padding: 5px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #007bff;
        color: #fff;
    }
    .btn-blue {
        padding: 8px 12px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin: 2px;
    }
    .btn-blue:hover {
        background-color: #0056b3;
    }
    .pagination {
        margin: 20px 0;
        text-align: center;
    }
    .pagination a, .pagination span {
        padding: 8px 12px;
        margin: 0 5px;
        border-radius: 5px;
        border: 1px solid #007bff;
        color: #007bff;
        text-decoration: none;
        font-size: 16px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    .pagination a:hover {
        background-color: #007bff;
        color: #fff;
    }
    .pagination span {
        background-color: #007bff;
        color: #fff;
    }
    form {
        display: inline;
    }
    form button {
        cursor: pointer;
    }
    .center-container {
        text-align: center;
        margin: 20px 0;
    }
    .logout-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 10px 20px;
        background-color: #dc3545;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    .logout-button:hover {
        background-color: #c82333;
    }
</style>';

echo '<div class="container">';
echo "<h1>Liste des clients</h1>";

// Formulaire de recherche et de filtre
echo '<div class="search-container">
        <form action="" method="get">
            <input type="text" name="search" placeholder="Rechercher par Chef de Projet" value="'.htmlspecialchars($search).'">
            <select name="activity">
                <option value="">Toutes les activités</option>';
                while ($activity_row = $activities_result->fetch_assoc()) {
                    $selected = ($activity_row['activite'] == $activity_filter) ? 'selected' : '';
                    echo '<option value="'.$activity_row['activite'].'" '.$selected.'>'.$activity_row['activite'].'</option>';
                }
echo '      </select>
            <button type="submit" class="btn-blue">Rechercher</button>
        </form>
      </div>';

// Afficher le tableau
echo '<div class="table-container">';

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Partenaire</th>
                <th>Nom Président</th>
                <th>Activité</th>
                <th>Projet</th>
                <th>Budget Débloqué</th>
                <th>Avancement</th>
                <th>Chef de Projet</th>
                <th>Actions</th>
            </tr>";
    // Afficher les données de chaque ligne
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['partenaire']."</td>
                <td>".$row['nom_president']."</td>
                <td>".$row['activite']."</td>
                <td>".$row['projet']."</td>
                <td>".$row['budget_debloque']."</td>
                <td>".$row['avancement']."</td>
                <td>".$row['chef_de_projet']."</td>
                <td>
                    <form action='edit.php' method='get'>
                        <input type='hidden' name='id' value='".$row['id']."'>
                        <button type='submit' class='btn-blue'>✏️ Éditer</button>
                    </form>
                    <form action='delete.php' method='post'>
                        <input type='hidden' name='id' value='".$row['id']."'>
                        <button type='submit' class='btn-blue'>🗑️ Supprimer</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucun client trouvé.</p>";
}

echo '</div>';

// Boutons centrés pour ajouter un client et exporter en Excel avec bouton corbeille
echo '<div class="center-container">
        <form action="form.php" method="get" style="display: inline;">
            <button type="submit" class="btn-blue">➕ Ajouter un client</button>
        </form>
        <form action="excel.php" method="get" style="display: inline;">
            <button type="submit" class="btn-blue">📥 Exporter en Excel</button>
        </form>
        <form action="corbeille.php" method="get" style="display: inline;">
            <button type="submit" class="btn-blue">🗑️ Voir la corbeille</button>
        </form>
      </div>';

// Liens de pagination
echo '<div class="pagination">';

// Afficher le lien précédent
if ($page > 1) {
    echo '<a href="?page='.($page - 1).'&search='.urlencode($search).'&activity='.urlencode($activity_filter).'">Précédent</a>';
}

// Afficher les numéros de page
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo '<span>'.$i.'</span>';
    } else {
        echo '<a href="?page='.$i.'&search='.urlencode($search).'&activity='.urlencode($activity_filter).'">'.$i.'</a>';
    }
}

// Afficher le lien suivant
if ($page < $total_pages) {
    echo '<a href="?page='.($page + 1).'&search='.urlencode($search).'&activity='.urlencode($activity_filter).'">Suivant</a>';
}

echo '</div>';

// Bouton de déconnexion
echo '<form action="logout.php" method="post">
        <button type="submit" class="logout-button">Se déconnecter</button>
      </form>';

echo '</div>';

// Fermer la connexion
$conn->close();
?>
