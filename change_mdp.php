<?php
if (isset($_POST['bout'])) {
    $mail = $_POST['mail'];
    $mdp = $_POST['mdp'];
    $newmdp = $_POST['newmdp'];
    $newmdp2 = $_POST['newmdp2'];
    $id = mysqli_connect("localhost", "root", "", "chat");
    $req = "select * from user where mail='" . $mail . "'" ;
    $res = mysqli_query($id, $req);
    $user = mysqli_fetch_assoc($res);

    if (mysqli_num_rows($res) == 1 && $user['mdp'] == $mdp) {
        if ($mdp == $newmdp) {
            echo "Le nouveau mot de passe doit être différent de l'ancien";
        } else {
            if ($newmdp == $newmdp2) {
                if (!validatePassword($newmdp)) {
                    echo "Le mot de passe doit contenir au moins 8 caractères et au moins 3 des 4 catégories de caractères (majuscules, minuscules, chiffres, caractères spéciaux).";
                } else {
                    $req = "update user set mdp='" . $newmdp . "' where mail='" . $mail . "'";
                    $res = mysqli_query($id, $req);
                    echo "Mot de passe changé avec succès";
                    header("refresh:3;url=connexion.php");
                    exit;
                }
            } else {
                echo "Les mots de passe ne correspondent pas";
            }
        }
    } else {
        echo "Mot de passe incorrect";
    }
}




function validatePassword($mdp) {
    $lengthCriteria = strlen($mdp) >= 8;
    $i = 0;
    if (preg_match('/[A-Z]/', $mdp)) {
        $i++;
    }
    if (preg_match('/[a-z]/', $mdp)) {
        $i++;
    }
    if (preg_match('/[0-9]/', $mdp)) {
        $i++;
    }
    if (preg_match('/[\W_]/', $mdp)) {
        $i++;
    }

    return $lengthCriteria && $i >= 3;
}
  
  

  
  
  ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>changer le mot de passe</h1>
    <form action="" method="post">
        <input type="text" name="mail" placeholder="Entrez votre mail :" required> <br><br>
        <input type="password" name="mdp" placeholder="Entrez votre mot de passe actuel :" required> <br><br>
        <input type="password" name="newmdp" placeholder="Entrez votre nouveau mot de passe :" required> <br><br>
        <input type="password" name="newmdp2" placeholder="Confirmez votre nouveau mot de passe :" required> <br><br>
        <input type="submit" value="changer" name="bout">

    </form>
</body>
</html>