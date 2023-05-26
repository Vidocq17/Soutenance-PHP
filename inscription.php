<?php
require ('functions.php');


session_start();

if(isset($_POST['register'])) {

    /* Intéret de faire un tableau d'erreurs plutot qu'un required dans le formulaire : 
        Le tableau est dans le PHP donc le back, côté serveur donc il n'est pas accessible par l'utilisateur,
        contrairement au required qui est en HTML donc côté client donc accessible par le code source et donc 
        modifiable */ 

    // empty vérifie si la variable est vide et si elle existe déjà. 
    if(not_empty(['lastname','firstname','pseudo','password','email','password_confirm'])) {

        $errors = []; // Tableau contenant les erreurs

        
         // retourne le nombre de caractères
        if(mb_strlen($_POST($pseudo) < 3)) {
            $errors[] ="Erreur : pseudo trop court, 3 caractères minimum";
        } 

        if(mb_strlen($_POST($password) < 6)) {
            $errors[] ="Erreur : mot de passe trop court, 6 caractères minimum";
        } else {
            if($_POST($password) != $_POST($password_confirm)) {
                $errors[] ="Erreur : mot de passe incorrect";
            }
        }
        // permet de vérifier si adresse email valide
        if(!filter_var($_POST($email, FILTER_VALIDATE_EMAIL))){
            $errors[]="Erreur : email invalide";
         
    } else {
        // errreur rajoutée si il y a des erreurs
        $errors[] = "Veuillez remplir tous les champs ";
    } 
      // Vérifier que le pseudo et l'adresse mail ne sont pas déja enregistrées. 
     /* if(is_already_in_use('pseudo',$pseudo, 'user')) {
        $errors[] = "Pseudo déja utilisé";
    }
    if(is_already_in_use('email',$email, 'user')) {
        $errors[] = "Adresse mail déja utilisé";
    } */ 

    // if(count($errors) == 0) {
        // Enregistrement de l'utilisateur si pas derreur dans le formulaire
        
        // Message de bienvenue
        
        // Redirect page Home. 
    }
}
// }

?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="inscription.css">
<head>
    <title>Inscription à WeTchat</title>
</head>
<body>
    <h1>Devenez membre !</h1>
    <!-- Affichage du mesage d'erreur -->
    <?php 
    if (isset($error)) :
     echo $error; 
     endif; ?>

    <form method="POST" action="home.php">

            <!-- lastname field -->
            <label for="lastname">Nom :</label>
            <input type="text" id="lastname" name="lastname" required> <br/>

            <!-- firstname field -->
            <label for="firstname">Prénom :</label>
            <input type="text" id="firstname" name="firstname" required> <br/>

            <!-- pseudo field -->
            <label for="pseudo">Pseudo :</label>
            <input type="text" id="pseudo" name="pseudo" required> <br/>

            <!-- genre field -->
            <label>Genre:</label><br/>
            <input type="radio"id="Autre" name="genre"value="Autre" Checked> 
            <label for="Autre">Autre</label>
            <input type = "radio" id="Femme"name="genre"value="Femme"> 
            <label for="Femme">Femme</label>
            <input type ="radio" id ="'Homme" name="genre" value="Homme">
            <label for="Homme">Homme</label><br/>

            <!-- email field -->
            <label for="email">Mail :</label>
            <input type="email" id="email" name="email" required> <br/>

            <!-- password field -->
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required> <br/>

            <!-- password confirmation field -->
            <label for="password_confirm">Confirmez votre mot de passe :</label>
            <input type="password" id="password_confirm" name="password_confirm" required> <br/>            

            <input type="submit" class="btn btn-primary" value="Inscription" name="register">
        </div>
    </form>
    <p>Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>
</body>
</html>
