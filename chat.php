<?php
session_start();
if (!isset($_SESSION['mail'])) {
    header("Location: connexion.php");
    exit();
}

$id = mysqli_connect("localhost", "root", "", "chat");

if (!$id) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["bout"])) {
    $pseudo = $_SESSION['prenom'];
    $message = $_POST["message"];
    $destinataire = $_POST["drestinataire"];

    $req = "INSERT INTO messages(pseudo, message, date, destinataire) VALUES (?, ?, NOW(), ?)";
    $stmt = mysqli_prepare($id, $req);
    mysqli_stmt_bind_param($stmt, 'sss', $pseudo, $message, $destinataire);

    if (mysqli_stmt_execute($stmt)) {
        // Message sent successfully
    } else {
        echo "Error: " . mysqli_error($id);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Chat</h1>
        <h2>Bienvenue <?php echo htmlspecialchars($_SESSION['prenom']); ?></h2>
        <div class="messages">
            <ul>
            <?php
            $req1 = "SELECT * FROM messages WHERE destinataire = ? OR pseudo = ? OR destinataire = 'tous' ORDER BY date ";
            $stmt = mysqli_prepare($id, $req1);
            mysqli_stmt_bind_param($stmt, 'ss', $_SESSION['prenom'], $_SESSION['prenom']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($ligne = mysqli_fetch_assoc($result)) {
                $dest = $ligne['destinataire'];
                $pseudo = $ligne['pseudo'];
                if ($ligne['pseudo'] == $_SESSION['prenom']) {
                    $pseudo = "moi";
                } elseif ($ligne['destinataire'] == $_SESSION['prenom']) {
                    $pseudo = $ligne['pseudo'];
                }

                $class = $dest == 'tous' ? 'public' : 'private';
                echo "<li class='mess $class'>
                        <span class='date'>" . htmlspecialchars($ligne['date']) . "</span>
                        <span class='pseudo'>" . htmlspecialchars($pseudo) . "</span>";
                if ($dest != 'tous') {
                    echo "<span class='destinataire'> à : " . htmlspecialchars($dest) . "</span>";
                }
                echo "<span class='content'>" . htmlspecialchars($ligne['message']) . "</span>
                    </li>";
            }
            ?>
            </ul>
        </div>

        <div class="formulaire">
            <form action="" method="POST">
                <input type="text" name="message" placeholder="Message :" required>
                <select name="drestinataire" id="">
                    <option value="">Destinataire</option>
                    <option value="tous" selected>Tous</option>
                    <?php
                    $resultat = mysqli_query($id, "SELECT DISTINCT prenom FROM user ORDER BY prenom");
                    while ($ligne = mysqli_fetch_assoc($resultat)) {
                        $pseudo = htmlspecialchars($ligne["prenom"]);
                        echo "<option value='$pseudo'>$pseudo</option>";
                    }
                    ?>
                </select><br><br>
                <input type="submit" value="ENVOYER" name="bout">
            </form>
            <a href="logout.php">Déconnexion</a>
        </div>
    </div>
    <script>
        const messagesDiv = document.querySelector('.messages');
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    </script>
</body>
</html>
