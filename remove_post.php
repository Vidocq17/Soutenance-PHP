<?php
session_start();
// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirection vers la page de connexion ou affichage d'un message d'erreur
    header('Location: inscription.php');
    exit();
}

// Vérification si un post_id a été passé en paramètre
if (!isset($_GET['post_id'])) {

    // Redirection vers la page de gestion des posts ou affichage d'un message d'erreur
    echo "Vous n'avez pas encore de post";
    exit();
}

// Connexion à la base de données
$host = 'mysql:host=localhost:8889;dbname=Soutenance_PHP';
$usernameDB = 'root';
$passwordDB = 'root';

$pdo = new PDO($host, $usernameDB, $passwordDB);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération de l'ID de l'utilisateur connecté
$user_id = $_SESSION['user_id'];

// Vérification si le post appartient à l'utilisateur connecté
$post_id = $_POST['post_id'];
$query = "SELECT * FROM post WHERE post_id = :post_id AND user_id = :user_id";
$statement = $pdo->prepare($query);
$statement->bindValue(':post_id', $post_id);
$statement->bindValue(':user_id', $user_id);
$statement->execute();
$post = $statement->fetch(PDO::FETCH_ASSOC);


if (!$post) {
    // Redirection vers la page de gestion des posts ou affichage d'un message d'erreur
    header('Location: posts.php');
    exit();
}

// Suppression du post de la base de données
$query = "DELETE FROM post WHERE post_id = :post_id";
$statement = $pdo->prepare($query);
$statement->bindValue(':post_id', $post_id);
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
            <a href="my_posts.php">Retour à mes posts</a>
        </div>
    </div>
</body>
</html>
