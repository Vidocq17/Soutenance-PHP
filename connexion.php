<?php
session_start();

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération des 2 données nécessaires pour le formulaire de connexion. 
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    // Connexion à la base de données avec PDO - Préciser le localhost puisque MAMP à imposé ça !
    $host = 'mysql:host=localhost:8889;dbname=Soutenance_PHP'; 
    $username = 'root'; 
    $dbPassword = 'root';

    try {
        // Connection à la base de données
        $pdo = new PDO($host, $username, $dbPassword);

        // Requête de bdd
        $query = "SELECT pseudo, password FROM user WHERE pseudo = :pseudo";
        $statement = $pdo->prepare($query);
        $statement->execute(['pseudo' => $pseudo]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Vérification du pseudo
            if ($user['pseudo'] === $pseudo) {
                // Vérification du mot de passe
                if (password_verify($password, $user['password'])) {
                    // Les informations de connexion sont correctes
                    echo "Connexion réussie!";
                    header('Location: home.php');
                } else {
                    // Le mot de passe est incorrect
                    echo "Mot de passe incorrect.";
                }
            } else {
                // Le pseudo est incorrect
                echo "Pseudo incorrect.";
            }
        }
    } catch (PDOException $e) {
        // Erreur de connexion à la base de données
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f1f1f1;
}

.container {
    max-width: 400px;
    margin: 20vh auto;
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
    margin-bottom: 10px;
}

form input[type="text"],
form input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-bottom: 10px;
}

form button[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

form button[type="submit"]:hover {
    background-color: #45a049;
}

.error {
    color: red;
    margin-bottom: 10px;
}

a {
    color: black;
    text-decoration: none;
}
.links a {
    display: flex;
    justify-content: center;
    flex-direction: row;
}
.links a:hover {
    color: red;
}

</style>

<head>
    <title>Connexion</title>
</head>
<body>
    <div class="container">
    <h1>Connexion</h1>
    <?php if (isset($error)): ?>
        <div><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="connexion.php">
        <div>
            <label for="pseudo">Pseudo :</label>
            <input type="text" id="pseudo" name="pseudo" required>
        </div>
        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit">Se connecter</button>
        </div>
    </form>
    <div class="links">
    <a href="inscription.php">S'inscrire</a>
    <a href="index.php">Page d'accueil</a>
    </div>
    </div>
</body>
</html>

