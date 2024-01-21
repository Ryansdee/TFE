<?php
include '../base.php';

// Vérifiez si l'utilisateur est connecté
session_start();

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else{
    header ('Location: ../connexion');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ryansdee - TFE</title>
    <link rel="stylesheet" href="../style.css">
    <meta name="author" content="Ryansdee">
    <meta name="description" content="Bienvenue sur mon site pour mon tfe!">
    <meta name="keywords" content="ryan tfe, tfe, Ryan, Deschuyteneer, deschuyteneer">
</head>
<body>
<header>
    <div class="nav">
    <a href="/" class="home">Accueil</a>
    <a href="../profil.php" class="profile"><?php echo $username ?></a>
    <a href="../look.php" class="recherche">Rechercher</a>
    <img src="/images/Ryansdee.png" alt="logo" class="logo" onclick="window.location.href='/'">
    <a href="../publish" class="publish">publish</a>
    </div>
</header>
<?php
    // ... (code existant)

    $posts_query = "SELECT posts.*, users.username FROM posts
                    INNER JOIN users ON posts.username = users.username
                    ORDER BY posts.created_at DESC";
    $result = $conn->query($posts_query);

    // Vérifiez si la requête a réussi
    if ($result && $result->num_rows > 0) {
        // Affichez les posts
        echo '<div id="posts">'; // Ouvrir la balise div pour la liste des posts
        while ($row = $result->fetch_assoc()) {
            echo '<div class="post">';

            // Affichez l'image s'il y en a une
            if (!empty($row['image_path'])) {
                echo '<img src="' . $row['image_path'] . '" alt="Post Image">';
            } 

            echo '<p>' . $row['content'] . '</p>';
            echo '<a href="../profile.php?user=' . $row['username'] . '">' . $row['username'] . '</a>';
            echo '</div>';
        }
        echo '</div>'; // Fermer la balise div pour la liste des posts
    } else {
        // Aucun résultat trouvé
        echo 'Aucun post trouvé.';
    }
    ?>
</body>
</html>