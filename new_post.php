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


// récupération des valeurs dans le formulaire : 
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
        // Attribution des $
    $title =  $_POST['title'];
    $content =  $_POST['content'];
   // $user_id = $_POST['user_id'];
// Code d'accès à la bdd
    $host = 'mysql:host=localhost:8889;dbname=Soutenance_PHP';
    $usernameDB = 'root';
    $passwordDB = 'root';
// Connexion à la bdd
    $pdo = new PDO("mysql:host=localhost:8889;dbname=Soutenance_PHP", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// requète d'insertion dans la table SQL
    $query = ("INSERT INTO Post (title, content, userId) VALUES (?, ?, ?)");

    try {
        $statement = $pdo->prepare($query);
        // Identification des variables dans le formulaire
        $statement->execute([$user_id, $title,$content,]);
        
        echo "Nouveau post enregistré";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nouveau post</title>
</head>
<body>
    <h1>Nouveau post</h1>
    <form method="POST" action="new_post.php">
        <div>
            <label for="title">Titre du post : </label>
            <input type="text" name="title" id ="title">
        </div>
        <div>
            <label for="content">Contenu du post :</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        <div>
            <label for="image">Image :</label>
            <input type="file" id="image" name="image">
        </div>
        <div>
            <label for="tags">Tags :</label>
            <input type="text" id="tags" name="tags">
        </div>
        <div>
            <button type="submit">Publier</button>
        </div>
    </form>
</body>
</html>
<!--
INSERT INTO 
SELECT * FROM POST where user.id=?
associer des variables 
php avec html et echo variables 
-->