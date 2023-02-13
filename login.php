<?php 
$is_invalid = false;
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $mysqli = require(__DIR__ . "/db.php");
    $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

if($user){
   if(password_verify($_POST["password"], $user["password_hash"])){
       session_start();

       session_regenerate_id();
       
       $_SESSION["user_id"] = $user["id"];

       header("Location: index.php");
    } 
}
$is_invalid = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://classless.de/classless.css">

</head>
<body>
    <h1>Login</h1>

    <?php if($is_invalid): ?>
        <em>Invalid Login</em>
    <?php endif; ?>


    <form method="POST">
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST["email"] ?? ""); ?>">
        </div>
        <div>
            <label for="password">password</label>
            <input type="password" id="password" name="password">
        </div>
       
    <button type="submit">Login</button>
</form>
    
</body>
</html>