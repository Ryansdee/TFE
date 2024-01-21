<?php
$servername = "185.98.131.177";
$username = "ryans2262525";
$password = "Sarah2021@";
$dbname = "ryans2262525";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}
?>