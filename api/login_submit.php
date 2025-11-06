<?php
require_once '../db/sopoppedDB.php';

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

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

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_name'] = $user['first_name'];
$_SESSION['logged_in'] = true;


header('Location: ../home.php?success=Login successful');
exit;
?>



