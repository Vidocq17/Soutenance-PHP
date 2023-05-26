<?php
$host = 'mysql:host=localhost;dbname=Soutenance_PHP'; 
$username = 'root'; 
$password = ''; 

try{
    // PDO à la place de Mysqli !!
$connection = new PDO($host, $username, $password);
}catch(PDOException $e) {
    die('Erreur'.$e ->getMessage());
}

session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: connexion.php'); // Rediriger vers la page d'accueil si l'utilisateur est déjà connecté
    exit();
}

$sql = "INSERT INTO  ('lastname','firstname',pseudo','password','gender','email') VALUES
     (:lastname,:firstname,:pseudo,:password,:gender,:email)";
    $q = $conn->prepare($sql);
    $q->execute(array(':lastname'=>$lastname,
                  ':firstname'=>$firstname,
                  ':pseudo'=>$pseudo,
                  ':password'=>$password,
                  ':gender'=>$gender,
                  ':email'=>$email));