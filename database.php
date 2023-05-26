<?php
$host = 'mysql:host=localhost:8889;dbname=Soutenance_PHP'; 
$username = 'root'; 
$password = ''; 

try{
    // PDO à la place de Mysqli !!
$connection = new PDO($host, $username, $password);
}catch(PDOException $e) {
    die('Erreur'.$e ->getMessage());
}

session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: connexion.php'); // Rediriger vers la page d'accueil si l'utilisateur est déjà connecté
    exit();
}
