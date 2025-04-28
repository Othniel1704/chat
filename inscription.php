<?php
if(isset($_POST["bout"])){
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $mail = $_POST["mail"];
    $mdp = $_POST["mdp"];
   
    $id = mysqli_connect("localhost","root","","chat");
    $req = "select * from user where mail='$mail'";
    $res = mysqli_query($id, $req);
    if(mysqli_num_rows($res) != 0){
        echo "Le mail : $mail est déjà présent dans la base, inscription impossible.";
    } else {
        if(!validatePassword($mdp)){  
            echo "Le mot de passe doit contenir au moins 8 caractères et au moins 3 des 4 catégories de caractères (majuscules, minuscules, chiffres, caractères spéciaux).";
        } else {
            $mdp = password_hash($mdp, PASSWORD_BCRYPT);
            $req = "insert into user (nom, prenom, mail, mdp, role) values ('$nom','$prenom','$mail','$mdp', 1 )";
            $res = mysqli_query($id, $req);
            echo "Inscription réussie, Vous allez être redirigé pour vous connecter....";
            header("refresh:3;url=connexion.php");
        }
    }
    }
    function validatePassword($mdp) {
        $lengthCriteria = strlen($mdp) >= 8;
        $categories = 0;
        if (preg_match('/[A-Z]/', $mdp)) {
            $categories++;
        }
        if (preg_match('/[a-z]/', $mdp)) {
            $categories++;
        }
        if (preg_match('/[0-9]/', $mdp)) {
            $categories++;
        }
        if (preg_match('/[\W_]/', $mdp)) {
            $categories++;
        }

        return $lengthCriteria && $categories >= 3;
    }
    ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="inscription.css">
    <style>
        body{
            padding: 20px;
            text-align: center;
        }
        form{
            margin-top: 20px;
            font-size: 18px;
            border: 1px solid #0c0a0a;
            border-radius: 50px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Inscription</h2>
    <form action="" method="post">
        <input type="text" name="nom" placeholder="Entrez votre nom :" required> <br><br>
        <input type="text" name="prenom" placeholder="Entrez votre prénom :" required> <br><br>
        <input type="email" name="mail" placeholder="Entrez votre mail :" required> <br><br>
        <input type="password" name="mdp" placeholder="Mot de passe :" required> <br><br>
        <input type="submit" value="S'INSCRIRE" name="bout">
    </form>
    <p>Déjà un compte? <a href="connexion.php">Connectez-vous ici</a></p>
</div>
</body>
</html>
