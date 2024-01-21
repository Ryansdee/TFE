<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="css/profile.css">
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
    // Inclure votre logique de connexion à la base de données si nécessaire
    include 'base.php';

    session_start();

    // Vérifier si un utilisateur est spécifié dans l'URL
    if (isset($_GET['user'])) {
        $username = $_GET['user'];

        // Récupérer les informations de l'utilisateur à partir de la base de données
        $userData = getUserDataFromDatabase($username);

        // Afficher les informations de l'utilisateur
        if ($userData) {
            echo '<h1 class="username">@' . $username . '</h1>';

            // Afficher l'image de profil si elle existe
            if (!empty($userData['profile_image'])) {
                echo '<div class="pdp"><img src="' . $userData['profile_image'] . '" alt="Image de profil"></div>';
            } else {
                echo 'L\'utilisateur n\'a pas d\'image de profil.';
            }

            // Afficher les posts de l'utilisateur
            $user_id = $userData['id'];
            $posts_query = "SELECT posts.*, users.username 
                            FROM posts 
                            INNER JOIN users ON posts.username = users.username
                            WHERE users.username = ? 
                            ORDER BY posts.created_at DESC";

            $stmt_posts = $conn->prepare($posts_query);
            $stmt_posts->bind_param("s", $username);
            $stmt_posts->execute();
            $result_posts = $stmt_posts->get_result();

            // Afficher les posts de l'utilisateur
            
            echo '<h2 class="name">Posts de ' . $username . '</h2>';
            echo '<div id="posts">';
            while ($row_post = $result_posts->fetch_assoc()) {
                echo '<div class="post">';

                // Affichez l'image s'il y en a une
                if (!empty($row_post['image_path'])) {
                    echo '<img src="' . $row_post['image_path'] . '" alt="Post Image">';
                }

                echo '<p>' . $row_post['content'] . '</p>';
                echo '<p>' . $row_post['username'] . '</p>';
                echo '</div>';
            }
            echo '</div>'; //
        } else {
            echo 'Utilisateur non trouvé';
        }
    } else {
        echo 'Aucun utilisateur spécifié';
    }

    // Fonction pour récupérer les données de l'utilisateur depuis la base de données
    function getUserDataFromDatabase($username)
    {
        global $conn; // Assurez-vous que la connexion est accessible dans cette fonction

        $query = "SELECT id, username, profile_image FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Retournez les données sous forme de tableau associatif
            return $result->fetch_assoc();
        } else {
            // L'utilisateur n'est pas trouvé
            return false;
        }
    }
    ?>

    <form id="followForm" action="follow.php" method="post">
        <input type="hidden" name="following_username" value="<?php echo $username; ?>">
        <button type="submit">Suivre</button>
    </form>

    <script>
        // Ajoutez ce script pour basculer entre les onglets
        document.addEventListener("DOMContentLoaded", function () {
            // Cache toutes les sections sauf la première
            document.querySelectorAll('.tabs a').forEach(function (tab) {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    var targetId = this.getAttribute('href').substr(1);
                    document.querySelectorAll('section').forEach(function (section) {
                        section.style.display = 'none';
                    });
                    document.getElementById(targetId).style.display = 'block';
                });
            });
        });
    </script>
</body>

</html>
