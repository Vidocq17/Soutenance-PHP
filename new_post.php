<?php 

session_start()

?>

<!DOCTYPE html>
<html>
<head>
    <title>Nouveau post</title>
</head>
<body>
    <h1>Nouveau post</h1>
    <form method="POST" action="traitement_post.php">
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
