<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: inscription.php');
    exit();
}

if (!isset($_GET['post_id'])) {
    echo "Le post à modifier n'a pas été spécifié.";
    exit();
}

    $post_id = $_GET['post_id'];

    $host = 'mysql:host=localhost:8889;dbname=Soutenance_PHP';
    $usernameDB = 'root';
    $passwordDB = 'root';

    $pdo = new PDO("mysql:host=localhost:8889;dbname=Soutenance_PHP", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM post WHERE post_id = :post_id AND user_id = :user_id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':post_id', $post_id);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    $post = $statement->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "Le post spécifié n'existe pas ou ne vous appartient pas.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $query = "UPDATE post SET title = :title, content = :content WHERE post_id = :post_id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':content', $content);
    $statement->bindValue(':post_id', $post_id);
    $statement->execute();

    header('Location: posts.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un post</title>
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

        form {
            margin-bottom: 20px;
        }

        form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        form input[type="text"],
        form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .button-container {
            text-align: center;
        }

        .button-container button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button-container button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modifier un post</h1>
        <form method="POST">
            <div>
                <label for="title">Titre :</label>
                <input type="text" id="title" name="title" value="<?php echo $post['title']; ?>" required>
            </div>
            <div>
                <label for="content">Contenu :</label>
                <textarea id="content" name="content" rows="5" required><?php echo $post['content']; ?></textarea>
            </div>
            <div class="button-container">
                <button type="submit">Enregistrer les modifications</button>
            </div>
        </form>
        <div class="button-container">
            <a href="posts.php">Retour</a>
        </div>
    </div>
</body>
</html>
