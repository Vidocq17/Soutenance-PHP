<?php
session_start();

// Destruction de la session
session_destroy();

// Redirection vers la page de connexion ou une autre page de votre choix
header('Location: index.php');
exit();
?>
