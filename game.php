<?php
session_start();
include "php/db.php";

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Banana Puzzle Game</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="game-container" style="text-align:center; margin-top:50px;">
        <h1>Banana Puzzle Game</h1>
        <p>Score: <span id="score">0</span></p>
        <img id="puzzle-img" src="" alt="Banana Puzzle" style="max-width:400px; border-radius:10px; margin-bottom:20px;">
        <br>
        <input type="number" id="user-answer" placeholder="Enter your answer">
        <button id="submit-btn">Submit</button>
        <p id="feedback" style="font-weight:bold;"></p>
        <br>
        <a href="dashboard.php"><button>Back to Dashboard</button></a>
    </div>

<script>
let score = 0;
let correctAnswer = null;

// Fetch puzzle from PHP Banana API bridge
function loadPuzzle(){
    fetch('php/fetch_banana.php')
        .then(res => res.json())
        .then(data => {
            if(data.error){
                alert(data.error);
            } else {
                document.getElementById('puzzle-img').src = data.question;
                correctAnswer = parseInt(data.solution);
                document.getElementById('feedback').innerText = '';
                document.getElementById('user-answer').value = '';
            }
        })
        .catch(err => console.error(err));
}

document.getElementById('submit-btn').addEventListener('click', () => {
    const userInput = document.getElementById('user-answer').value.trim();

    if(userInput === ""){
        alert("Please enter an answer!");
        return;
    }

    const userAns = Number(userInput);  // convert to number
    const correctAns = Number(correctAnswer);  // ensure number

    console.log("User answer:", userAns, "Correct answer:", correctAns, typeof correctAns);

    if(userAns === correctAns){
        score += 1;
        document.getElementById('feedback').innerText = "Correct! 🎉";
        document.getElementById('score').innerText = score;

        // Save score
        fetch('save_score.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'score=' + score
        }).then(res => res.text()).then(console.log);

    } else {
        document.getElementById('feedback').innerText = "Wrong! Try next puzzle.";
    }

    // Load next puzzle
    loadPuzzle();
});

// Load first puzzle on page load
loadPuzzle();
</script>

</body>
</html>