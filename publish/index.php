<?php
session_start();
require_once '../base.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assurez-vous que l'utilisateur est connecté
    if (!isset($_SESSION['username'])) {
        echo 'Vous devez être connecté pour publier.';
        exit();
    }

    $username = $_SESSION['username'];
    $content = $_POST['content'];

    // Gestion de l'image
    $image_dir = '../posts/';
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_path = $image_dir . $image_name;

    // Déplacez l'image téléchargée vers le dossier d'uploads
    move_uploaded_file($image_tmp, $image_path);

    // Insérer le post dans la base de données
    $insert_query = "INSERT INTO posts (username, content, image_path) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sss", $username, $content, $image_path);

    if ($stmt->execute()) {
        echo 'Post publié avec succès.';
    } else {
        echo 'Erreur lors de la publication du post.';
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publication</title>
    <link rel="stylesheet" href="../publish.css">
</head>
<body>
    <header>
        <a href="/connected" class="home">Accueil</a>
    </header>

    <form id="publishForm" method="post" enctype="multipart/form-data">
        <textarea name="content" placeholder="Quoi de neuf ?" required></textarea>
        <input type="file" name="image" accept="image/video">
        <button type="submit">Publier</button>
    </form>

</body>
</html>
