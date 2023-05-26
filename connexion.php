<?php
session_start();

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des 2 données nécessaires pour le formulaire de connexion. 
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    // Connexion à la base de données avec PDO
    $host = 'mysql:host=localhost;dbname=Soutenance_PHP'; 
    $username = 'root'; 
    $dbPassword = '';

    try {
        // Connection à la base de données
        $connection = new PDO($host, $username, $dbPassword);
        // Requête de bdd
        $query = "SELECT * FROM user WHERE pseudo = :pseudo";
        $statement = $connection->prepare($query);
        $statement->execute(['pseudo' => $pseudo]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Les informations de connexion sont correctes
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['pseudo'] = $user['pseudo'];
            header('Location: home.php'); // Rediriger vers la page d'accueil après la connexion réussie
            exit();
        } else {
            $error = 'Nom d\'utilisateur ou mot de passe incorrect.';
        }
    } catch (PDOException $e) {
        $error = 'Erreur de connexion à la base de données : ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
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
    <p>Pas encore inscrit ? <a href="inscription.php">S'inscrire</a></p>
</body>
</html>
