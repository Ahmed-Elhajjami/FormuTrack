<?php
session_start();
session_destroy();
header('Location: register.php'); // Redirige vers la page de connexion
exit();
?>
