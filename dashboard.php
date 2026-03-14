<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="card">
        <h1>Welcome</h1>
        <p>You are logged in.</p>
        <a href="game.php"><button>Play Banana Game</button></a>
        <a href="leaderboard.php"><button>View Leaderboard</button></a>
        <a href="logout.php"><button>Logout</button></a>
    </div>
</body>
</html>