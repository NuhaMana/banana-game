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
<body class="game-body">
    <div id="bg-game"></div>

    <div id="game-container" class="card">
        <h1>Banana Puzzle Game</h1>
        <p>Score: <span id="score">0</span></p>

        <!-- Timer -->
        <div id="timer-container">
            <div id="timer-bar"></div>
        </div>
        <p id="timer-text">Time Left: 20s</p>

        <!-- Puzzle -->
        <img id="puzzle-img" src="" alt="Banana Puzzle">
        <br>

        <!-- Answer input -->
        <input type="number" id="user-answer" placeholder="Enter your answer">
        <button id="submit-btn">Submit</button>

        <p id="feedback"></p>
        <br>
        <a href="dashboard.php"><button>Back to Dashboard</button></a>
    </div>

<script>
let timerDuration = 20;
let timer;
let score = 0;
let correctAnswer = null;

// Load puzzle and start timer only after image loads
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

// Timer
function startTimer() {
    clearInterval(timer);
    let timeLeft = timerDuration;
    document.getElementById('timer-text').innerText = "Time Left: " + timeLeft + "s";
    document.getElementById('timer-bar').style.width = "100%";

    timer = setInterval(() => {
        timeLeft--;
        document.getElementById('timer-text').innerText = "Time Left: " + timeLeft + "s";
        document.getElementById('timer-bar').style.width = (timeLeft / timerDuration * 100) + "%";

        if(timeLeft <= 0){
            clearInterval(timer);
            document.getElementById('feedback').innerText = "Time's up! Next puzzle.";
            setTimeout(loadPuzzle, 1000);
        }
    }, 1000);
}

function spawnBackgroundEmojis(page){

    const emojiSets={
        login:["🍌","🍌","🍌","🐒"],
        register:["🍌","🍌","🍌","🐒","🌴"],
        dashboard:["🍌","🍌","🍌","🍌","🐒","🌴","🍍"],
        game:["🍌","🍌","🍌","🍌","➕","➗","🐒"]
    };

    const emojis=emojiSets[page]||["🍌","🍌","🐒"];

    const rows=6;
    const cols=10;

    const cellWidth=window.innerWidth/cols;
    const cellHeight=window.innerHeight/rows;

    for(let r=0;r<rows;r++){
        for(let c=0;c<cols;c++){

            const obj=document.createElement("div");
            obj.className="bg-object";

            obj.innerHTML=emojis[Math.floor(Math.random()*emojis.length)];

            const x=(c*cellWidth)+(Math.random()*cellWidth*0.6);
            const y=(r*cellHeight)+(Math.random()*cellHeight*0.6);

            obj.style.left=x+"px";
            obj.style.top=y+"px";

            obj.style.fontSize=(32+Math.random()*26)+"px";

            obj.style.animationDuration=(3+Math.random()*3)+"s";
            obj.style.animationDelay=(Math.random()*2)+"s";

            document.body.appendChild(obj);
        }
    }
}
spawnBackgroundEmojis("game"); // change per page

// Submit answer
document.getElementById('submit-btn').addEventListener('click', () => {
    const userInput = document.getElementById('user-answer').value.trim();
    if(userInput === ""){
        alert("Please enter an answer!");
        return;
    }

    const userAns = Number(userInput);
    clearInterval(timer);

    console.log("User answer:", userAns, "Correct answer:", correctAnswer);

    if(userAns === correctAnswer){
        score++;
        document.getElementById('feedback').innerText = "Correct! 🎉";
        document.getElementById('score').innerText = score;

        fetch('save_score.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'score=' + score
        }).then(res => res.text()).then(console.log);
    } else {
        document.getElementById('feedback').innerText = "Wrong! Try next puzzle.";
    }

    setTimeout(loadPuzzle, 1000);
});

// Load first puzzle
loadPuzzle();
</script>
</body>
</html>