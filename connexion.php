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
        $query = "SELECT pseudo  FROM user WHERE pseudo = :pseudo";
        $statement = $pdo->prepare($query);
        $statement->execute(['pseudo' => $pseudo]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
        } else {
            $errors[] = 'Ce pseudo est déjà utilisé. Veuillez en choisir un autre.';
        } 
        
        $query = "SELECT password  FROM user WHERE password = :password";
        $statement = $pdo->prepare($query);
        $statement->execute(['password' => $password]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        
        
        if ($user) {
        } else {
            $errors[] = 'Mot de passe incorrect.';
            
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

