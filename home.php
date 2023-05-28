<?php
session_start();

?>
<!DOCTYPE html>
<html>
    <style>
header {
display: flex;
flex-direction: row;
}

header ul {
    display: flex;
    align-items: center;
}

header ul li {
    margin-left: 50px;
    color: green;
}
    </style>
<head>
    <title>Accueil</title>
</head>
<header>
    <ul>
        <li>Accueil</li>
        <li>Posts</li>
        <li>Commentaires</li>
        <li>Paramètres</li>
    </ul>
</header>
<body>
    <h1>BRAVO <? $_POST[$firstname] ?>  C'EST CONNECTÉ</h1>
    <a href="new_post.php"><button>Ajouter un post</button></a>
</body>
</html>
