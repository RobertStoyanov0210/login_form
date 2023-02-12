<?php
$mysqli = require(__DIR__ . "/db.php");
$sql = "INSERT INTO user (name, email, password_hash)
VALUES (?, ?, ?)";
$stmt = $mysqli->stmt_init();


// Name validation
if(empty($_POST["name"])){
    die("Name required");
}
// Email validation
if(empty($_POST["email"])){
    die("Email required");
}
else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Invalid Email");
}
// Password Validation
if(strlen($_POST["password"]) < 5){
    die("Password is too short");
}
if(!preg_match("/[a-z]/i", $_POST["password"])){
    die("Not containing any letters");
}
if(!preg_match("/[0-9]/i", $_POST["password"])){
    die("Not containing any letters");
}

if($_POST["password"] != $_POST["password_confirmation"]){
    die("Password do not match");
}

if(!$stmt->prepare($sql)){
    die("SQL error: " . $mysqli->error);
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$stmt->bind_param("sss",$_POST["name"], $_POST["email"], $password_hash);
if($stmt->execute()){
 header("Location: signup-success.html");
 exit;
} else{
    if($mysqli->errno === 1062){
        die("Email already taken");
    }else{
        die("Execute error: " . $mysqli->errno);
    }
}
