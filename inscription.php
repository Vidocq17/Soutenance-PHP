<?php

session_start();

if (isset($_POST['register'])) {
    $errors = [];

    // Récupération des valeurs soumises dans le formulaire
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $gender = $_POST['genre'];
    //$date_naissance = $_POST['date_naissance'];
    $email = $_POST['email'];


    $host = 'mysql:host=localhost:8889;dbname=Soutenance_PHP';
    $usernameDB = 'root';
    $passwordDB = 'root';

    $pdo = new PDO("mysql:host=localhost:8889;dbname=Soutenance_PHP", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    try {
        // Requête pour vérifier si l'adresse e-mail existe déjà dans la base de données
        $query = "SELECT * FROM user WHERE email = :email";
        $statement = $pdo->prepare($query);
        $statement->execute(['email' => $email]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $errors[] = 'Cette adresse e-mail est déjà utilisée. Veuillez en choisir une autre.';
        } else {
            
            // Validation du pseudo
            if (strlen($pseudo) < 3) {
                $errors[] = 'Le pseudo doit contenir au moins 3 caractères.';
            } else {
                // Enregistrement de l'utilisateur si pas d'erreurs dans le formulaire
                // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            } 
        }


        $pdo = new PDO("mysql:host=localhost:8889;dbname=Soutenance_PHP", "root", "root");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "INSERT INTO user (lastname, firstname, pseudo, gender, email, password /* date_naissance */ ) VALUES (:lastname, :firstname, :pseudo, :genre, :email, :password /*:date_naissance) */ )";
        $statement = $pdo->prepare($query);

        $statement->execute([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'pseudo' => $pseudo,
            'password' => $password,
            'genre' => $gender,
          //  'date_naissance' => $date_naissance,
            'email' => $email 
        ]); 

        // Redirection vers la page home.php après l'enregistrement
        header("Location: home.php");
        exit();
    } catch (PDOException $e) {
        $errors[] = 'Erreur de connexion à la base de données : ' . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="inscription.css">

<head>
    <title>Inscription à WeTchat</title>
</head>

<body>
    <h1>Devenez membre !</h1>
    <!-- Affichage des messages d'erreur -->
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="inscription.php">
        <!-- lastname field -->
        <label for="lastname">Nom :</label>
        <input type="text" id="lastname" name="lastname" required><br />

        <!-- firstname field -->
        <label for="firstname">Prénom :</label>
        <input type="text" id="firstname" name="firstname" required><br />

        <!-- pseudo field -->
        <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" required><br />

        <!-- gender field -->
        <label>Genre:</label><br />
        <input type="radio" id="Autre" name="genre" value="A" checked>
        <label for="Autre">Autre</label>
        <input type="radio" id="Femme" name="genre" value="F">
        <label for="Femme">Femme</label>
        <input type="radio" id="'Homme" name="genre" value="H">
        <label for="Homme">Homme</label><br />

        <!-- birthyear field
        <label for="date_naissance">Date de naissance:</label>
        <input type="date" name="date_naissance" id="date_naissance"><br /> -->

        <!-- email field -->
        <label for="email">Mail :</label>
        <input type="email" id="email" name="email" required><br />

        <!-- password field -->
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br />

        <!-- password confirmation field -->
        <label for="password_confirm">Confirmez votre mot de passe :</label>
        <input type="password" id="password_confirm" name="password_confirm" required><br />

        <input type="submit" class="btn btn-primary" value="Inscription" name="register">
    </form>
    <p>Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>
</body>

</html>