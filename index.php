<?php
session_start();

if(isset($_SESSION["user_id"])){
    $mysqli = require(__DIR__ . "/db.php");
    $sql = "SELECT * FROM user WHERE id={$_SESSION["user_id"]}";
    
    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="https://classless.de/classless.css">

</head>
<body>
    <h1>Home</h1>

    <?php if(isset($user)): ?>
        <h1>Welcome, <?= htmlspecialchars($user["name"]);?>. You are loged in!</h1>
        <p><a href="logout.php">Log out</a></p>
    <?php else: ?>
        <p><a href="login.php">Log in</a> or <a href="signup.html">Sign Up</a></p>
    <?php endif; ?>
</body>
</html>