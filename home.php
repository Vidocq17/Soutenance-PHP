<?php
// démarrer la session d'utilisateur
session_start();


// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirection vers la page de connexion si pas connecté
    header('Location: inscription.php');
    exit();
}
// 2léments de connection à la bdd
$host = 'mysql:host=localhost:8889;dbname=Soutenance_PHP';
$usernameDB = 'root';
$passwordDB = 'root';
// Requète de connection à la bdd
$pdo = new PDO("mysql:host=localhost:8889;dbname=Soutenance_PHP", "root", "root");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer les posts depuis la bdd
$query = "SELECT * FROM post";
$statement = $pdo->prepare($query);
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

// Récupérer le prénom de l'utilisateur depuis la bdd
$user_id = $_SESSION['user_id'];
$query = "SELECT firstname FROM user WHERE user_id = :user_id";
$statement = $pdo->prepare($query);
$statement->bindParam(':user_id', $user_id);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
$firstname = $user['firstname'];

// Attribution du prénom à la variable de session
$_SESSION['firstname'] = $firstname;
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
        }

        header ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        header ul li {
            display: inline-block;
            margin-right: 10px;
        }

        header ul li:last-child {
            margin-right: 0;
        }

        header ul li a {
            color: white;
            text-decoration: none;
        }

        header ul li a:hover {
            text-decoration: underline;
        }

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

        .post {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .post h2 {
            margin-bottom: 10px;
        }

        .post p {
            margin-bottom: 10px;
        }

        .post .meta {
            font-size: 12px;
            color: #666;
        }

        .post .meta span {
            margin-right: 10px;
        }

        .logout {
            text-align: right;
        }

        .logout a {
            color: #666;
            text-decoration: none;
        }

        .logout a:hover {
            text-decoration: underline;
        }
    </style>
    <title>Accueil</title>
</head>
<body>
<header>
    <ul>
        <li><a href="home.php">Accueil</a></li>
        <li><a href="posts.php">Posts</a></li>
        <li><a href="comments.php">Commentaires</a></li>
        <li>Paramètres</li>
    </ul>
    <ul class="logout">
       <a href="Compte/inscription.php"> <li>Se déconnecter</li></a>
    </ul>
</header>
<div class="container">
    <h1>Bienvenue <?php echo isset($_GET['firstname']) ? $_GET['firstname'] : $firstname ?>, </h1>
    <a href="new_post.php"><button>Ajouter un post</button></a>
</div>
<div class="posts">
    <?php foreach ($posts as $post) {
        $postId = $post['post_id'];
        $title = $post['title'];
        $content = $post['content'];
        $user_id = $post['user_id'];
        ?>
        <div class="post">
            <h2><?php echo $title; ?></h2>
            <p><?php echo $content; ?></p>
            <div class="meta">
            <span>Posté par utilisateur <?php echo $_SESSION['firstname']; ?></span>
            </div>
           <a href="comment.php"> <button>Commenter</button> </a>
        </div>
    <?php } ?>
</div>
</body>
</html>
