<?php
session_start();


?>
<!DOCTYPE html>
<html>
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
<head>
    <title>Accueil</title>
</head>
<header>
    <ul>
        <a href="home.php"> <li>Accueil</li> </a>
        <a href="my_posts"> <li>Posts</li></a>
        <a href="my_comments"><li>Commentaires</li></a>
        <li>Paramètres</li>
    </ul>
    <ul class="logout">
        <li>Se déconnecter</li>
    </ul>
</header>
<body>
    <div class="container">
    <h1>BRAVO <? $_POST[$firstname] ?>  C'EST CONNECTÉ</h1>
    <a href="new_post.php"><button>Ajouter un post</button></a>
    </div>
</body>
</html>
