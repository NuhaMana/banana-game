<?php
session_start();
include "php/db.php";

$message = "";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "Email already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $message = "Registration successful! You can now login.";
        } else {
            $message = "Registration failed!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="bg-register"></div>

    <div class="card">
        <h2>Create Account</h2>
        <p style="color:red;"><?php echo $message; ?></p>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Enter username" required>
            <input type="email" name="email" placeholder="Enter email" required>
            <input type="password" name="password" placeholder="Enter password" required>
            <button type="submit" name="register">Register</button>
        </form>
        <p><a href="login.php">Already have an account? Login</a></p>
    </div>

<script>
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
spawnBackgroundEmojis("register"); // change per page
</script>

</body>
</html>