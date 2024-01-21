<?php
include '../base.php';

// Démarrer la session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Utilisation d'une requête préparée
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Enregistrez le nom d'utilisateur dans la session
            $_SESSION['username'] = $username;
            // Redirigez l'utilisateur vers la page connectée
            header('Cache-Control: no-cache, must-revalidate');
            header('Location: /connected');
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Nom d'utilisateur introuvable.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Ryansdee</title>
    <link rel="stylesheet" href="../connexion.css">
    <meta name="author" content="Ryansdee">
    <meta name="description" content="Bienvenue sur mon site pour mon tfe!">
    <meta name="keywords" content="ryan tfe, tfe, Ryan, Deschuyteneer, deschuyteneer">
</head>
<body>
    <div class="nav">
    <a href="/" class="home">Accueil</a>
    <a href="/inscription" class="connexion">inscription</a>
    <img src="/images/Ryansdee.png" alt="logo" class="logo" onclick="window.location.href='/'">
    </div>
    <img src="../images/Ryan.png" alt="" class="ryan">
    <p class="intro">Salut tout le monde,<br>
        Je me présente Ryansdee!<br>
        J'ai fait ce mini réseau social pour mon tfe. <br>
        Donc ceci est mon produit finale ;)</p>
<form method="post">
        <img src="../images/Ryansdee.png" alt="">
        <label id="nom">Nom d'utilisateur:</label>
        <input type="text" name="username" required id="user"><br>
        
        <label id="mdp">Mot de passe:</label>
        <input type="password" name="password" required id="pswd"><br>
        <div class="ins"><p>Pas encore <a href="/inscription" class="connect">inscrit</a>?</p></div>
        <input type="submit" value="Se connecter" id="bouton">
    </form>
</body>
</html>
