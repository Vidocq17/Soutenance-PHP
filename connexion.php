<?php
// Vérification si l'utilisateur est déjà connecté
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: home.php'); // Rediriger vers la page d'accueil si l'utilisateur est déjà connecté
    exit();
}

// Vérification formulaire connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification des informations de connexion dans la bdd
    $host = 'localhost';
    $dbUsername = 'root';
    $dbPassword = 'root';
    $dbName = 'Soutenance';

    $connection = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);
    if (!$connection) {
        die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
    }

    $query = "SELECT id, username, password FROM User WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: home.php'); // Rediriger vers la page d'accueil après la connexion réussie
            exit();
        }
    }

    $error = 'Identifiant ou mot de passe incorrect.';
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<link rel="stylesheet" href="connexion.css">

<header>
    <h1>Bienvenue sur WeChat !</h1>
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quibusdam et veniam modi fuga, tenetur sequi amet velit assumenda porro pariatur reprehenderit esse nisi a quas, laborum ut distinctio ratione nesciunt.</p>

</header>

<body>
    
    <?php if (isset($error)): ?>
        <div><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="home.php">

        <div class="content">
        <div>
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit"form="home.php">Se connecter</button>
        </div>
    </form>
    <p>Pas encore inscrit ? <a href="inscription.php">S'inscrire</a></p>
    </div>
</body>
</html>

