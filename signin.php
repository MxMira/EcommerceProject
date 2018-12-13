<?php

$email = '';
$password = '';
$remember = '';
$validinput = true;
$querystring = '?';

// if  there is a session already opened for this user
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
    $stmt = $conn->prepare("select * from users where email=:email And password=:password");
    $pass = md5($password);
    $stmt->execute(['email' => $email, 'password'=>$pass]);
    $arr = $stmt->fetch();
    if ($arr) {
        require 'userClass.php';
        $user = new user();
        $user->id = $arr['ID'];
        $user->full_name = $arr['full_name'];
        $user->email = $arr['email'];
        $user->created_at = $arr['created_at'];
        $user->created_by = $arr['created_by'];
        $user->role = $arr['role'];
        $user->status = $arr['status'];
        $user->mobile = $arr['mobile'];
        $_SESSION['user'] = serialize($user);

        if ($remember == 1) {
            setcookie('mail', $user->email, time() + 60 * 60 * 24 );
            $token = generateToken();
            setcookie('token', $token, time() + 60 * 60 * 24 );
            $stmt = $conn->prepare("update users set token=? where email=?");
            $stmt->execute([$token,$user->email]);
            $stmt->errorInfo();
        }

        header('location:mainpage.php');
    } else {
        setcookie('umailSourcyaTest', NULL, time() - 3600);
        setcookie('upasswordSourcyaTest', NULL, time() - 3600);
        header('location:index.php?msg=invaliduser');
    }
}else{
    header('location:index.php' . $querystring);
}
$conn = null;

function generateToken($charLen = 32){
    $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
    $max = count($characters) - 1;
    $str = '';
    for ($i = 0; $i < $charLen; $i++) {
        $str .= $characters[rand(0, $max - 1)];
    }
    return $str;
}
        