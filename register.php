<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="card">
        <h2>Create Account</h2>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Enter username" required>
            <input type="email" name="email" placeholder="Enter email" required>
            <input type="password" name="password" placeholder="Enter password" required>
            <button type="submit" name="register">Register</button>
        </form>
        <p><a href="login.php">Already have an account? Login</a></p>
    </div>
</body>
</html>