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
    <title>Banana Game</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="card">
        <h1>🍌 Banana Puzzle</h1>
        <p>Score: <span id="score">0</span></p>
        <img id="bananaImage" src="" alt="Banana Question">
        <input type="number" id="answer" placeholder="Enter your answer">
        <button onclick="checkAnswer()">Submit Answer</button>
        <button onclick="loadQuestion()">Next Puzzle</button>
        <p id="message"></p>
        <a href="dashboard.php" class="top-btn">Back to Dashboard</a>
    </div>

    <script src="js/game.js"></script>
</body>
</html>