<?php
session_start();
// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirection vers la page de connexion ou affichage d'un message d'erreur
    header('Location: inscription.php');
    exit();
}
// Connexion à la base de données
$host = 'mysql:host=localhost:8889;dbname=Soutenance_PHP';
$usernameDB = 'root';
$passwordDB = 'root';

$pdo = new PDO("mysql:host=localhost:8889;dbname=Soutenance_PHP", "root", "root");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Récupération des posts de l'utilisateur
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM post WHERE user_id = :user_id";
$statement = $pdo->prepare($query);
$statement->bindValue(':user_id', $user_id);
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

// Récupérer le prénom de l'utilisateur depuis la bdd
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
    <title>Mes posts</title>
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
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <ul>
            <li><a href="home.php">Accueil</a></li>
            <li><a href="posts.php">Posts</li></a>
            <li><a href="comments.php">Commentaires</a></li>
            <li><a href="settings.php">Paramètres</li></a>
        </ul>
        <ul class="logout">
            <li><a href="logout.php">Se déconnecter</a></li>
        </ul>
    </header>

    <div class="container">
        <h1>Posts de <?php echo isset($_GET['firstname']) ? $_GET['firstname'] : $firstname ?> </h1>
        <a href="new_post.php"><button>Ajouter un post</button></a>
        <a href="edit_post.php"><button name="update">Modifier un post</button></a>
        <a href="remove_post.php?post_id=<?php echo $post['post_id']; ?>"><button name="remove"> Supprimer un post </button></a>

        <?php foreach ($posts as $post) { ?>
            <div class="post">
                <h2><?php echo $post['title']; ?></h2>
                <p><?php echo $post['content']; ?></p>
                <div class="meta">
                <span>Posté par utilisateur <?php echo $_SESSION['firstname']; ?></span>
                </div>
            </div>
            <div class="btn">
                <!-- Préciser l'id du post, pas idéal mais j'ai rien trouvé de mieux pour l'instant -->
            <a href="edit_post.php?post_id=<?php echo $post['post_id']; ?>"><button>Modifier le post</button></a>
            <a href="remove_post.php?post_id=<?php echo $post['post_id']; ?>"><button>Supprimer le post</button></a>
            </div>
        <?php } ?>
    </div>
</body>
</html>