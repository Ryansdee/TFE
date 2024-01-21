<?php
session_start();
require_once 'base.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $follower_username = $_SESSION['username'];

    // Vérifier si la clé 'following_username' existe dans $_POST
    $following_username = isset($_POST['following_username']) ? $_POST['following_username'] : null;

    // Vérifier si la clé 'username' existe dans $_GET
    $following_username_from_url = isset($_GET['username']) ? $_GET['username'] : null;

    // Utiliser la valeur de l'URL s'il est défini, sinon utiliser la valeur du formulaire
    $following_username_to_use = $following_username_from_url ?? $following_username;

    // Vérifier si la relation de suivi existe déjà
    $check_query = "SELECT * FROM followers WHERE follower_username = ? AND following_username = ?";
    
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ss", $follower_username, $following_username_to_use);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Si la relation existe, supprimer le suivi (arrêter de suivre)
        $delete_query = "DELETE FROM followers WHERE follower_username = ? AND following_username = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("ss", $follower_username, $following_username_to_use);
        $stmt->execute();
        echo "unfollow"; // Vous pouvez utiliser cette valeur pour mettre à jour le texte du bouton côté client
    } else {
        // Si la relation n'existe pas, ajouter le suivi
        $insert_query = "INSERT INTO followers (follower_username, following_username) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ss", $follower_username, $following_username_to_use);
        $stmt->execute();
        echo "follow"; // Vous pouvez utiliser cette valeur pour mettre à jour le texte du bouton côté client
    }
}
?>
