<?php

session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirection vers la page de connexion ou affichage d'un message d'erreur
    header('Location: inscription.php');
    exit();
}

// Récupération de l'ID de l'utilisateur connecté
$userId = $_SESSION['user_id'];

// Récupérer le post_id depuis l'URL
if (!isset($_GET['post_id'])) {
    echo "Vous n'avez pas sélectionné de post à commenter"; ?>
    <a href="home.php"><button>Retour à l'accueil</button></a>
    <?php
    exit();
}
$post_id = $_GET['post_id'];

// récupération des valeurs dans le formulaire :
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Attribution des variables
    $comment_title = $_POST['comment_title'];
    $comment_content = $_POST['comment_content'];
    $user_id = $_SESSION['user_id'];

    // Code d'accès à la bdd
    $host = 'mysql:host=localhost:8889;dbname=Soutenance_PHP';
    $usernameDB = 'root';
    $passwordDB = 'root';

    $pdo = new PDO("mysql:host=localhost:8889;dbname=Soutenance_PHP", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // requète d'insertion dans la table SQL
    $query = "INSERT INTO comment (title, content, user_id, post_id) VALUES (?, ?, ?, ?)";

    try {
        $statement = $pdo->prepare($query);
        // Identification des variables dans le formulaire
        $statement->execute([$comment_title, $comment_content, $user_id, $post_id]);

        echo "Nouveau commentaire enregistré";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<html>
<head>
    <title>Nouveau commentaire</title>
    <!DOCTYPE html>
<html>
<head>
    <title>Nouveau commentaire</title>
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            margin-top: 20vh;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group textarea,
        .form-group input[type="file"] {
            width: 100%;
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .form-group input[type="file"] {
            cursor: pointer;
        }

        .form-group button[type="submit"],
        .form-group a.button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group a.button {
            background-color: #ccc;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nouveau commentaire</h1>
        <form method="POST" action="new_comment.php?post_id=<?php echo $post_id; ?>">
            <div class="form-group">
                <label for="title">Titre du commentaire (optionnel) :</label>
                <input type="text" name="comment_title" id="title">
            </div>
            <div class="form-group">
                <label for="content">Contenu du commentaire :</label>
                <textarea id="content" name="comment_content" required></textarea>
            </div>
            <div class="form-group">
                <label for="tags">Tags :</label>
                <input type="text" id="tags" name="tags">
            </div>
            <div class="form-group">
                <button type="submit">Publier</button>
                <a href="home.php" class="button">Accueil</a>
                <a href="posts.php" class="button">Mes posts</a>
            </div>
        </form>
    </div>
</body>
</html>