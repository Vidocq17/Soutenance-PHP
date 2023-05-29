<?php
session_start();
// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirection vers la page de connexion ou affichage d'un message d'erreur
    header('Location: inscription.php');
    exit();
}

// Vérification si un comment_id a été passé en paramètre
if (!isset($_GET['comment_id'])) {
    // Redirection vers la page de gestion des posts ou affichage d'un message d'erreur
    echo "Le commentaire à modifier n'a pas été spécifié.";
    exit();
}

// Récupération du comment_id depuis les paramètres de l'URL
$comment_id = $_GET['comment_id'];

// Connexion à la base de données
$host = 'mysql:host=localhost:8889;dbname=Soutenance_PHP';
$usernameDB = 'root';
$passwordDB = 'root';

$pdo = new PDO($host, $usernameDB, $passwordDB);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération de l'ID de l'utilisateur connecté
$user_id = $_SESSION['user_id'];

// Vérification si le commentaire appartient à l'utilisateur connecté
$query = "SELECT * FROM comment WHERE comment_id = :comment_id AND user_id = :user_id";
$statement = $pdo->prepare($query);
$statement->bindValue(':comment_id', $comment_id);
$statement->bindValue(':user_id', $user_id);
$statement->execute();
$comment = $statement->fetch(PDO::FETCH_ASSOC);

if (!$comment) {
    // Redirection vers la page de gestion des posts ou affichage d'un message d'erreur
    echo "Le commentaire spécifié n'existe pas ou ne vous appartient pas.";
    exit();
}

// Suppression du post de la base de données
$query = "DELETE FROM comment WHERE comment_id = :comment_id";
$statement = $pdo->prepare($query);
$statement->bindValue(':comment_id', $comment_id);
$statement->execute();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Supprimer un post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .button-container {
            text-align: center;
        }

        .button-container a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .button-container a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Supprimer un post</h1>
        <div class="message">
            Le post a été supprimé avec succès.
        </div>
        <div class="button-container">
            <a href="posts.php">Retour à mes posts</a>
        </div>
    </div>
</body>
</html>
