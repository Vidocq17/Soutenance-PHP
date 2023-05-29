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

// Traitement du formulaire de modification de commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $comment_title = $_POST['comment_title'];
    $comment_content = $_POST['comment_content'];

    // Mise à jour du commentaire dans la base de données
    $query = "UPDATE comment SET title = :comment_title, content = :comment_content WHERE comment_id = :comment_id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':comment_title', $comment_title);
    $statement->bindValue(':comment_content', $comment_content);
    $statement->bindValue(':comment_id', $comment_id);
    $statement->execute();    

    // Redirection vers la page de gestion des commentaires ou affichage d'un message de succès
    header('Location: comments.php');
    exit();
}
?>

<html>
<head>
    <title>Modifier le commentaire</title>
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
        <h1>Modifier le commentaire</h1>
        <form method="POST">
            <div class="form-group">
                <label for="title">Titre du commentaire (optionnel) :</label>
                <input type="text" name="comment_title" id="title" value="<?php echo $comment['title']; ?>">
            </div>
            <div class="form-group">
                <label for="content">Contenu du commentaire :</label>
                <textarea id="content" name="comment_content" required><?php echo $comment['content']; ?></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Modifier</button>
                <a href="comments.php" class="button">Retour</a>
            </div>
        </form>
    </div>
</body>
</html>







