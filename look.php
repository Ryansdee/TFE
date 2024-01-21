<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche Utilisateur</title>
    <link rel="stylesheet" href="css/look.css">
    <meta name="author" content="Ryansdee">
    <meta name="description" content="Bienvenue sur mon site pour mon tfe!">
    <meta name="keywords" content="ryan tfe, tfe, Ryan, Deschuyteneer, deschuyteneer">
</head>
<body>
<header>
    <a href="/connected" class="home">Accueil</a>
</header>

<?php
// Inclure votre logique de connexion à la base de données si nécessaire
include 'base.php';

session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['username'])) {
    $follower_username = $_SESSION['username'];

    // Traitement du formulaire de recherche
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_input = trim($_POST['search']); // Supprime les espaces au début et à la fin de la chaîne
    if (!empty($search_input)) {
        $search_query = "%{$search_input}%";

        // Requête pour rechercher des utilisateurs
        $search_users_query = "SELECT username FROM users WHERE username LIKE ?";
        $stmt = $conn->prepare($search_users_query);
        $stmt->bind_param("s", $search_query);
        $stmt->execute();
        $result = $stmt->get_result();

        // Afficher les résultats de la recherche
echo '<h2>Résultats de la recherche :</h2>';
echo '<ul>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        echo '<li><a href="profile.php?user=' . $username . '">' . $username . '</a></li>';
    }
} else {
    echo '<li>Aucun résultat trouvé.</li>';
}

echo '</ul>';
    } else {
        echo 'Veuillez entrer une chaîne de recherche valide.';
    }
}

    // Formulaire de recherche
    echo '<form id="searchForm" action="look.php" method="post">';
    echo '<input type="text" name="search" placeholder="Rechercher des utilisateurs">';
    echo '<button type="submit">Rechercher</button>';
    echo '</form>';
    
} else {
    echo 'Vous devez être connecté pour utiliser la recherche.';
}
?>

</body>
</html>
