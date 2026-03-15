<?php
session_start();
include "php/db.php";

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

        <!-- Timer -->
        <div id="timer-container" style="margin: 10px auto; width: 60%; height: 25px; border-radius: 12px; background: #ddd; overflow: hidden;">
            <div id="timer-bar" style="height: 100%; width: 100%; background: linear-gradient(90deg, #ffd700, #ff7f50); transition: width 1s linear; border-radius: 12px;"></div>
        </div>
        <p style="text-align:center; font-weight:bold;" id="timer-text">Time Left: 20s</p>

        <!-- Puzzle -->
        <img id="puzzle-img" src="" alt="Banana Puzzle" style="max-width:400px; border-radius:10px; margin-bottom:20px;">
        <br>

        <!-- Answer input -->
        <input type="number" id="user-answer" placeholder="Enter your answer">
        <button id="submit-btn">Submit</button>

        <p id="feedback" style="font-weight:bold;"></p>
        <br>
        <a href="dashboard.php"><button>Back to Dashboard</button></a>
    </div>

<script>
let timerDuration = 20; 
let timer;   
let score = 0;
let correctAnswer = null;

function loadPuzzle() {
    document.getElementById('feedback').innerText = "Loading puzzle...";

    fetch('php/fetch_banana.php')
        .then(res => res.json())
        .then(data => {
            if(data.error){
                alert(data.error);
                return;
            }

            const img = document.getElementById('puzzle-img');
            correctAnswer = parseInt(data.solution);

            
            console.log("Correct answer for this puzzle:", correctAnswer);

            img.src = data.question;
            document.getElementById('user-answer').value = '';
            document.getElementById('feedback').innerText = '';

            
            img.onload = function() {
                startTimer();
            };
        })
        .catch(err => {
            console.error(err);
            document.getElementById('feedback').innerText = "Failed to load puzzle. Try refreshing.";
        });
}


function startTimer() {
    clearInterval(timer); 
    let timeLeft = timerDuration;
    document.getElementById('timer-text').innerText = "Time Left: " + timeLeft + "s";
    document.getElementById('timer-bar').style.width = "100%";

    timer = setInterval(() => {
        timeLeft--;
        document.getElementById('timer-text').innerText = "Time Left: " + timeLeft + "s";

        let percent = (timeLeft / timerDuration) * 100;
        document.getElementById('timer-bar').style.width = percent + "%";

        if (timeLeft <= 0) {
            clearInterval(timer);
            document.getElementById('feedback').innerText = "Time's up! Next puzzle.";
            setTimeout(loadPuzzle, 1000);
        }
    }, 1000);
}

// Submit button handler
document.getElementById('submit-btn').addEventListener('click', () => {
    const userInput = document.getElementById('user-answer').value.trim();
    if(userInput === ""){
        alert("Please enter an answer!");
        return;
    }

    const userAns = Number(userInput);
    clearInterval(timer); 

    console.log("User answer:", userAns, "Correct answer:", correctAnswer); // testing

    if(userAns === correctAnswer){
        score += 1;
        document.getElementById('feedback').innerText = "Correct! 🎉";
        document.getElementById('score').innerText = score;

        
        fetch('save_score.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'score=' + score
        }).then(res => res.text()).then(console.log);

        // Optional: trigger confetti
        // confetti();

    } else {
        document.getElementById('feedback').innerText = "Wrong! Try next puzzle.";
    }

    
    setTimeout(loadPuzzle, 1000);
});


loadPuzzle();
</script>

</body>
</html>