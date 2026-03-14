<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="card">
        <h2>Login</h2>
        <form action="" method="POST">
            <input type="email" name="email" placeholder="Enter email" required>
            <input type="password" name="password" placeholder="Enter password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p><a href="register.php">Don't have an account? Register</a></p>
    </div>
</body>
</html>