<?php
session_start();

if(isset($_POST["bout"])){
    $mail = $_POST["mail"];
    $mdp = $_POST["mdp"];
    $id = mysqli_connect("localhost","root","","chat");
    if (!$id) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $mdp = password_hash($mdp, PASSWORD_BCRYPT);
    
    $req = "select * from user where mail='$mail' ";
    $res = mysqli_query($id, $req);
    
 


    
    if(mysqli_num_rows($res) == 1){
        $user = mysqli_fetch_assoc($res);
        $lastPasswordChange = $user['modif_mdp'];
        $currentDate = date('Y-m-d H:i:s');
        
        if(diffdate($lastPasswordChange, $currentDate)){
            echo "Votre mot de passe a expiré, veuillez le changer";
            header("refresh:4;url=change_mdp.php");
            exit();
        }
        if (!password_verify($mdp, $user['mdp'])) {
            $erreur =  "<h3>Erreur de login ou de mot de passe!!!</h3>";
        } else {
            $_SESSION['id'] = $user['id'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['mail'] = $user['mail'];
            echo "Connexion réussie, Vous allez être redirigé vers le chat";
            header("location:chat.php");
            exit();
        }
    } else {
        $erreur =  "<h3>Erreur de login ou de mot de passe!!!</h3>";
    }
}

function diffdate($date1, $date2) {
    $datetime1 = new DateTime($date1);
    $datetime2 = new DateTime($date2);
    $interval = $datetime1->diff($datetime2);
    echo $interval->m;
    return $interval->m >= 1 || $interval->y > 0;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      body {
    font-family: Arial, sans-serif;
    background-color:rgb(3, 10, 15);
    margin: 0;
    padding: 0;
}

.container {
    width: 50%;
    margin: auto;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #4682b4;
}

input[type="email"], input[type="password"] {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    width: 100%;
    padding: 10px;
    background: #4682b4;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #4169e1;
}
    </style>
    
</head>
<body>
    <h1>Formulaire de connexion</h1><hr>
    <div class="container">
    <form action="" method="post">
        <input type="email" name="mail" placeholder="Entrez votre mail :" required> <br><br>
        <input type="password" name="mdp" placeholder="Mot de passe :" required> <br><br>
        <?php if(isset($erreur)) echo $erreur;?>
        <input type="submit" value="CONNEXION" name="bout">
    </form>
    <p>Pas encore de compte? <a href="inscription.php">Inscrivez-vous ici</a></p>
</div>
</body>
</html>
