<?php
session_start();
include "php/db.php";

if (!isset($_SESSION['user_id'])) {
    exit("User not logged in");
}

if (isset($_POST['score'])) {
    $user_id = $_SESSION['user_id'];
    $score = intval($_POST['score']);

    $stmt = $conn->prepare("INSERT INTO scores (user_id, score) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $score);
    $stmt->execute();

    echo "Score saved";
}
?>