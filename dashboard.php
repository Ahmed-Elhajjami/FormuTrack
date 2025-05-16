<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); //quand je clique sur le boutton ydin location li bghit :kndir smeya dial la page diali 
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "formulaire"; //le nom dial fichier diali 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch admin information
$admin_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT username FROM admins WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            font-family: 'Roboto', sans-serif;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            background-color: #7b59b6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #6849a6;
        }

        .logout-button {
            background-color: #d9534f;
        }

        .logout-button:hover {
            background-color: #c9302c;
        }

        p {
            text-align: center;
            color: #555;
        }

        a {
            color: #7b59b6;
            text-decoration: none;
            transition: color 0.3s;
        }

        a:hover {
            color: #543d9e;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bienvenue</h2>
        <button onclick="location.href='form.php'">Add Client</button>
        <button onclick="location.href='infos.php'">View Data</button>
        <button class="logout-button" onclick="location.href='register.php'">Logout</button>
    </div>
</body>
</html>
