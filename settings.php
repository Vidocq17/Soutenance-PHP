<?php
// démarrer la session d'utilisateur
session_start();


// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirection vers la page de connexion si pas connecté
    header('Location: inscription.php');
    exit();
}
// 2léments de connection à la bdd
$host = 'mysql:host=localhost:8889;dbname=Soutenance_PHP';
$usernameDB = 'root';
$passwordDB = 'root';
try {
    $pdo = new PDO($host, $usernameDB, $passwordDB);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Gestion des erreurs de connexion à la base de données
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Récupération de l'ID de l'utilisateur connecté
$user_id = $_SESSION['user_id'];

// Récupération des informations de l'utilisateur depuis la base de données
$query = "SELECT * FROM user WHERE user_id = :user_id";
$statement = $pdo->prepare($query);
$statement->bindValue(':user_id', $user_id);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Redirection ou affichage d'un message d'erreur si l'utilisateur n'existe pas
    echo "Utilisateur introuvable.";
    exit();
}

// Traitement du formulaire de mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des nouvelles valeurs des champs de formulaire
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];

    // Mise à jour des informations de l'utilisateur dans la base de données
    $query = "UPDATE user SET lastname = :lastname, firstname = :firstname, pseudo = :pseudo, email = :email WHERE user_id = :user_id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':lastname', $lastname);
    $statement->bindValue(':firstname', $firstname);
    $statement->bindValue(':pseudo', $pseudo);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();

    // Redirection vers la page de confirmation ou affichage d'un message de succès
    header('Location: settings.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Paramètres</title>
</head>
<body>
    <h1>Paramètres</h1>

    <form method="POST" action="settings.php">
        <label for="lastname">Nom :</label>
        <input type="text" name="lastname" id="lastname" value="<?php echo $user['lastname']; ?>"> <br/>

        <label for="firstname">Prénom :</label>
        <input type="firstname" name="firstname" id="firstname" value="<?php echo $user['firstname']; ?>"> <br>

        <label for="pseudo">Pseudo :</label>
        <input type="pseudo" name="pseudo" id="pseudo" value="<?php echo $user['pseudo']; ?>"> <br>

        <label for="email">Adresse e-mail :</label>
        <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>"> <br>

        <button type="submit">Enregistrer les modifications</button>
        <button><a href="home.php">Page d'accueil</a></button>
    </form>
</body>
</html>