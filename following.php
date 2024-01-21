<?php
include 'base.php';

// Vérifiez si l'utilisateur est connecté
session_start();

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivis</title>
    <link rel="stylesheet" href="style.css">
    <meta name="author" content="Ryansdee">
    <meta name="description" content="Bienvenue sur mon site pour mon tfe!">
    <meta name="keywords" content="ryan tfe, tfe, Ryan, Deschuyteneer, deschuyteneer">
</head>
<body>
<div class="nav">
    <a href="/connected" class="home">Accueil</a>
    <a href="profil.php" class="connexion"><?php echo $username ?></a>
    <img src="/images/Ryansdee.png" alt="logo" class="logo" onclick="window.location.href='/'">
    </div>
</body>
</html>
<?php
// Inclure le fichier de connexion
include 'base.php';


// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['username'])) {
    $follower_username = $_SESSION['username'];

    // Récupérer les utilisateurs suivis
    $following_query = "SELECT following_username FROM followers WHERE follower_username = ?";
    $stmt_following = $conn->prepare($following_query);
    $stmt_following->bind_param("s", $follower_username);
    $stmt_following->execute();
    $result_following = $stmt_following->get_result();

    // Afficher la liste des utilisateurs suivis
    echo '<h2>Utilisateurs que vous suivez</h2>';
    echo '<ul>';
    while ($row = $result_following->fetch_assoc()) {
        echo '<li>' . $row['following_username'] . '</li>';
    }
    echo '</ul>';
} else {
    echo 'Vous devez être connecté pour voir la liste des utilisateurs suivis.';
}
?>
