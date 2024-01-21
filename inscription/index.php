<?php
include '../base.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    // Vérifier si l'adresse e-mail est déjà enregistrée
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkEmailResult = $conn->query($checkEmailQuery);

    if ($checkEmailResult->num_rows > 0) {
        echo "Cette adresse e-mail est déjà associée à un compte.";
    } else {
        // Gérer le fichier d'image
        $targetDirectory = '../inscription/uploads/';  // Assurez-vous que ce dossier existe et a les permissions nécessaires
        $targetFile = $targetDirectory . basename($_FILES["profileImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Vérifier si le fichier image est une image réelle ou une fausse image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["profileImage"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                echo "Le fichier n'est pas une image.";
                $uploadOk = 0;
            }
        }

        // Vérifier si le fichier existe déjà
        if (file_exists($targetFile)) {
            echo "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }

        // Vérifier la taille du fichier
        if ($_FILES["profileImage"]["size"] > 500000) {
            echo "Désolé, le fichier est trop volumineux.";
            $uploadOk = 0;
        }

        // Autoriser certains formats de fichiers
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
        }

        // Vérifier si $uploadOk est défini à 0 par une erreur
        if ($uploadOk == 0) {
            echo "Désolé, votre fichier n'a pas été téléchargé.";
        } else {
            // Si tout est ok, tenter de télécharger le fichier
            if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
                header ('Location: /connected');

                // Utilisation d'une requête préparée pour l'insertion
                $stmt = $conn->prepare("INSERT INTO users (username, password, email, profile_image) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $username, $password, $email, $targetFile);

                if ($stmt->execute()) {
                    echo "Inscription réussie !";
                } else {
                    echo "Erreur d'inscription : " . $conn->error;
                }
                if ($_FILES["profileImage"]["error"] > 0) {
                    echo "Erreur de téléchargement : " . $_FILES["profileImage"]["error"];
                    exit; // Arrêtez l'exécution du script en cas d'erreur
                }
                $stmt->close();
            } else {
                echo "Une erreur s'est produite lors du téléchargement de votre fichier.";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../css/inscription.css">
    <meta name="author" content="Ryansdee">
    <meta name="description" content="Bienvenue sur mon site pour mon tfe!">
    <meta name="keywords" content="ryan tfe, tfe, Ryan, Deschuyteneer, deschuyteneer">
</head>
<body>
    <div class="nav">
    <a href="/" class="home">Accueil</a>
    <a href="/connexion" class="connexion">connexion</a>
    <a href="/inscription" class="inscription">inscription</a>
    <img src="/images/Ryansdee.png" alt="logo" class="logo" onclick="window.location.href='/'">
    </div>
    <form method="post" enctype="multipart/form-data">
        <img src="../images/Ryansdee.png" alt="">
        <label id="nom" >Nom d'utilisateur:</label>
        <input type="text" name="username" required id="user" ><br>
        
        <label id="mail" >Adresse e-mail:</label>
        <input type="email" name="email" required id="email" ><br>
        
        <label id="mdp">Mot de passe:</label>
        <input type="password" name="password" required id="pswd" ><br>

        <label id="pdp" >Photo de profil</label>
        <input type="file" name="profileImage" accept="image/*" required id="phdp" ><br>

        <input type="submit" name="submit" value="S'inscrire" id="bouton">
    </form>
</body>
</html>
