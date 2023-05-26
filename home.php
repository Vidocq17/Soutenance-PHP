
<!DOCTYPE html>
<html>
<head>
    <title class="home_title">Accueil</title>
</head>
<body>
    <div class="home_content">
    <h1>Bienvenue, <?php echo $POST_($username); ?>!</h1>
    <h2>Publications récentes :</h2>
    <?php foreach ($posts as $post): ?>
        <div>
            <h3><?php echo $post['title']; ?></h3>
            <p><?php echo $post['content']; ?></p>
            <p>Auteur : <?php echo $post['username']; ?></p>
        </div>
        <hr>
    <?php endforeach; ?>
    <p><a href="logout.php">Se déconnecter</a></p>
    </div>
</body>
</html>
