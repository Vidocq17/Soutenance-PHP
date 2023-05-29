<?php
session_start();

// Destruction de la session
session_destroy();

// Redirection vers la page de connexion ou une autre page de votre choix
header('Location: index.php');
exit();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
</head>
    <style>
        body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
        }

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
        .form-group input[type="password"],
        .form-group textarea {
        width: 100%;
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ccc;
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
    
</body>
</html>