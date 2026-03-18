let currentAnswer = 0;
let score = 0;

async function loadQuestion() {
    try {
        let response = await fetch("php/fetch_banana.php"); //int
        let data = await response.json();

        if (data.error) {
            document.getElementById("message").innerText = data.error;
            return;
        }

        document.getElementById("bananaImage").src = data.question;
        currentAnswer = data.solution;
        document.getElementById("answer").value = "";
        document.getElementById("message").innerText = "";
    } catch (error) {
        document.getElementById("message").innerText = "Error loading question";
    }
}

function checkAnswer() {
    let userAnswer = document.getElementById("answer").value;

    if (userAnswer === "") {
        document.getElementById("message").innerText = "Please enter an answer";
        return;
    }

    if (parseInt(userAnswer) === parseInt(currentAnswer)) {
        score++;
        document.getElementById("score").innerText = score;
        document.getElementById("message").innerText = "Correct!";
    } else {
        document.getElementById("message").innerText = "Wrong! Correct answer was " + currentAnswer;
    }
}

loadQuestion();