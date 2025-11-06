<?php
require_once '../db/sopoppedDB.php';

//creates session
session_start();

//assigns data from superglobal post to associated variable
//sanitize input for security purposes
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);;
$password = $_POST['password'];

//checks if fields are empty
if(empty($email) || empty($password)){
    header('Location: ../home.php?error=Please fill in all fields');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();


if(!$user){
    header('Location: ../home.php?error=Invalid email or password');
    exit;
}

if(!password_verify($password, $user['password_hash'])){
    header('Location: ../home.php?error=Invalid email or password');
    exit;
}

//creates seession
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_name'] = $user['first_name'];
$_SESSION['logged_in'] = true;


header('Location: ../home.php?success=Login successful');
exit;
?>