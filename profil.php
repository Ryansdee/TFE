<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="css/profil.css">
    <meta name="author" content="Ryansdee">
    <meta name="description" content="Bienvenue sur mon site pour mon tfe!">
    <meta name="keywords" content="ryan tfe, tfe, Ryan, Deschuyteneer, deschuyteneer">
</head>
<body>
    <div class="nav">
    <a href="/connected" class="home">Accueil</a>
    <img src="/images/Ryansdee.png" alt="logo" class="logo" onclick="window.location.href='/'">
    </div>
    <?php
// Inclure le fichier de connexion
include 'base.php';

session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['username'])) {
    $follower_username = $_SESSION['username'];

    // Récupérer les informations de l'utilisateur connecté depuis la base de données
    $user_query = "SELECT * FROM users WHERE username = ?";
    $stmt_user = $conn->prepare($user_query);
    $stmt_user->bind_param("s", $follower_username);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    // Vérifier si l'utilisateur existe dans la base de données
    if ($result_user->num_rows > 0) {
        $userData = $result_user->fetch_assoc();

        // Afficher le profil de l'utilisateur connecté
        echo '<h1 class="username">@' . $follower_username . '</h1>';

        // Afficher l'image de profil si elle existe
        if (!empty($userData['profile_image'])) {
            echo '<div class="pdp"><img src="' . $userData['profile_image'] . '" alt="Image de profil"></div>';
        } else {
            echo 'L\'utilisateur n\'a pas d\'image de profil.';
        }

        // Lien vers la page suivante pour afficher les utilisateurs suivis
        echo '<a href="following.php" class="suivis">Suivis</a>';
    } else {
        echo 'Utilisateur non trouvé.';
    }
} else {
    echo 'Vous devez être connecté pour voir votre profil.';
}
?>

<script>
// Ajoutez ce script pour basculer entre les onglets
document.addEventListener("DOMContentLoaded", function() {
    // Cache toutes les sections sauf la première
    document.querySelectorAll('section').forEach(function(section) {
        section.style.display = 'none';
    });
    document.getElementById('following').style.display = 'block';
});
</script>

</body>
</html>
