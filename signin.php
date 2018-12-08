<?php

$email = '';
$password = '';
$remember = '';
$validinput = true;
$querystring = '?';

// if  there is a seesion already opened for this user
session_start();
if (isset($_SESSION['inputEmail']) && isset($_SESSION['inputPassword'])) {
    $email = $_SESSION['inputEmail'];
    $password = $_SESSION['inputPassword'];
} else {
    if (!empty(trim($_POST['inputEmail']))) {
        $e = filter_var(trim($_POST['inputEmail']), FILTER_SANITIZE_EMAIL);
        if (filter_var($e, FILTER_VALIDATE_EMAIL) == true) {
            $email = filter_var($e, FILTER_VALIDATE_EMAIL);
            $querystring .= 'email=' . $email . '&';
        } else {
            $querystring .= 'email=notvalid&';
        }
    }else{
        $validinput = false;
        $querystring .= 'email=empty&';
    }
    if (!empty(trim($_POST['inputPassword']))) {
        $password = filter_var(trim($_POST['inputPassword']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    } else {
        $validinput = false;
        $querystring .= 'pw=empty&';
    }
    $remember = filter_input(INPUT_POST, 'remember', FILTER_SANITIZE_NUMBER_INT);
}

// if every input is set with a value
if ($validinput == true) {
    require 'require/dbconn.php';
    $stmt = $conn->prepare("select * from users where email=:email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $usID = $user['id'];
        $usName = $user['full_name'];
        $mail = $user['email'];
        $conn = null;
        $_SESSION['uid'] = $usID;
        $_SESSION['uname'] = $usName;

        if ($remember == 1) {
            setcookie('umailSourcyaTest', $mail, time() + 60 * 60 * 24 * 356);
            setcookie('upasswordSourcyaTest', $pass, time() + 60 * 60 * 24 * 356);
        }

        header('location:mainpage.php');
    } else {
        $conn = null;
        setcookie('umailSourcyaTest', NULL, time() - 3600);
        setcookie('upasswordSourcyaTest', NULL, time() - 3600);
        header('location:index.php?msg=invaliduser');
    }
}else{
    header('location:index.php' . $querystring);
}
        
        