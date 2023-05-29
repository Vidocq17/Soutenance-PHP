<?php
session_start();

// isset — Détermine si une variable est déclarée et est différente de null
if (isset($_POST['register'])) {
    $errors = [];

    // Récupération des valeurs soumises dans le formulaire
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
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
            // Pseudo moins de 3caractères. 
            if (strlen($pseudo) < 3) {
                $errors[] = 'Le pseudo doit contenir au moins 3 caractères.';
            } else {   
                if ($password === $password_confirm) {
                    // Hachage du mot de passe
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    // Enregistrement de l'utilisateur si pas d'erreurs dans le formulaire
                                                // valeurs dans la bdd                                        Valeurs du formulaire
                    $query = "INSERT INTO user (lastname, firstname, pseudo, gender, email, password) VALUES (:lastname, :firstname, :pseudo, :genre, :email, :password)";
                    // requete préparée
                    $statement = $pdo->prepare($query);
                    $statement->execute([
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'pseudo' => $pseudo,
                        'password' => $hashedPassword, 
                        'genre' => $gender,
                        'email' => $email 
                    ]);         
                    $_SESSION['user_id'] = $pdo->lastInsertId();

                    // Redirection après l'enregistrement
                    header("Location: home.php");
                    exit();
                } else {
                    $errors[] = "Les mots de passe sont différents";
                }
            }
        }
    } catch (PDOException $e) {
        $errors[] = 'Erreur de connexion à la base de données : ' . $e->getMessage();
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
        margin: 5vh auto;
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
    form input[type="password"],
    form textarea {
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
    <title>Inscription à WeTchat</title>
</head>

<body>
    <div class="container">
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
        <label>Genre:</label>
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

        <input type="submit" value="Inscription" name="register">
    </form>
    <div class="links">
    <a href="connexion2.php">Déjà inscrit ?</a>
    <a href="index.php">Page d'accueil</a>
    </div>
    </div>
</body>

</html>