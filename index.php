<!DOCTYPE html>
<html>
<head>
    <title>Banana Game</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="card">
        <h1>🍌 Banana Math Puzzle</h1>
        <p>Solve fun banana image puzzles and climb the leaderboard!</p>
        <a href="register.php"><button>Register</button></a>
        <a href="login.php"><button>Login</button></a>
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
</script> 
</body>
</html>