<?php
session_start();

setcookie('mail', null, time());
setcookie('token', null, time());

require 'require/dbconn.php';
require 'userClass.php';
$user = unserialize($_SESSION['user']);
$stmt = $conn->prepare("update users set token=? where email=?");
$stmt->execute([null, $user->email]);
$stmt->errorInfo();
$conn = null;

session_destroy();
header('location:index.php');
