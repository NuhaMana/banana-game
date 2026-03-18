<!DOCTYPE html>
<html>
<head>
    <title>Banana Game</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <!-- Glowing title above card -->
    <h1 class="home-title">🍌 Banana Puzzle 🍌</h1>

    <!-- Center card with main actions -->
    <div class="card" id="home-card">
        <p id="home-text">
            Test your brain with fun banana math puzzles!  
            Solve puzzles before time runs out and climb the leaderboard.
        </p>

        <a href="login.php"><button>Login</button></a>
        <a href="register.php"><button>Create Account</button></a>
    </div>

    <!--  buttons outside the card -->
    <div id="extra-buttons">
        <a href="leaderboard.php"><button class="top-btn">🏆 View Leaderboard</button></a>
        <a href="#" onclick="openHowToPlay(); return false;">
        <button class="top-btn">📘 How To Play</button>
</a>
    </div>

<div id="howToPlayModal" class="modal">
    <div class="modal-content">
        <span id="closeModal">&times;</span>
        <h2>🍌 How to Play</h2>
        <p>
            Solve banana math puzzles.<br><br>
            Enter the correct number before time runs out.<br>
            Each correct answer increases score.<br>
            Levels make the timer faster.<br>
            You have 3 lives.<br><br>
            Game ends when lives reach 0.
        </p>
    </div>
</div>
    


    <script>
   function spawnBackgroundEmojis(page){

    const emojiSets={
        login:["🍌","🍌","🍌","🐒"],
        register:["🍌","🍌","🍌","🐒","🌴"],
        dashboard:["🍌","🍌","🍌","🍌","🐒","🌴","🍍"],
        game:["🍌","🍌","🍌","🍌","➕","➗","🐒"],
        index:["🍌","🍌","➗","🐒"]
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

function spawnGoldParticles(){

    const particle=document.createElement("div");

    particle.className="gold-particle";

    particle.style.left=Math.random()*window.innerWidth+"px";
    particle.style.top=Math.random()*window.innerHeight+"px";

    particle.style.animationDuration=(4+Math.random()*4)+"s";

    document.body.appendChild(particle);

    setTimeout(()=>{
        particle.remove();
    },8000);
   
}

spawnBackgroundEmojis("index"); // change per page
setInterval(spawnGoldParticles,300);

function openHowToPlay(){
    document.getElementById("howToPlayModal").style.display = "flex";
}

window.onload = function(){

    document.getElementById("closeModal").onclick = function(){
        document.getElementById("howToPlayModal").style.display = "none";
    };

    window.onclick = function(e){
        if(e.target.id === "howToPlayModal"){
            document.getElementById("howToPlayModal").style.display = "none";
        }
    };

};

</script>
</body>
</html>