<?php

$fName = '';
$lName = '';
$mobile = '';
$email = '';
$password = '';
$fullname = '';
$validinput = true;
$querystring = '?';

if (!empty(trim($_POST['inputFirstName']))) {
    //removes tags and remove characters with ASCII value > 127
    $fName = filter_var(trim($_POST['inputFirstName']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $querystring .= 'fname=' . $fName . '&';
} else {
    $validinput = false;
    $querystring .= 'fname=empty&';
}
if (!empty(trim($_POST['inputLastName']))) {
    $lName = filter_var(trim($_POST['inputLastName']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $querystring .= 'lname=' . $lName . '&';
} else {
    $validinput = false;
    $querystring .= 'lname=empty&';
}
if (!empty(trim($_POST['inputMobile']))) {
    //removes all illegal characters from a number
    $mobile = filter_var(trim($_POST['inputMobile']), FILTER_SANITIZE_NUMBER_INT);
    $querystring .= 'mobile=' . $mobile . '&';
} else {
    $validinput = false;
    $querystring .= 'mobile=empty&';
}
if (!empty(trim($_POST['inputEmail']))) {
    //sanitizes and validates an email address
    $e = filter_var(trim($_POST['inputEmail']), FILTER_SANITIZE_EMAIL);
    if (filter_var($e, FILTER_VALIDATE_EMAIL) == true) {
        $email = filter_var($e, FILTER_VALIDATE_EMAIL);
        $querystring .= 'email=' . $email . '&';
    } else {
        $querystring .= 'email=notvalid&';
    }
} else {
    $validinput = false;
    $querystring .= 'email=empty&';
}
if (!empty(trim($_POST['inputPassword']))) {
    $password = filter_var(trim($_POST['inputPassword']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
} else {
    $validinput = false;
    $querystring .= 'pw=empty&';
}
if (!empty(trim($_POST['inputConfirmPassword']))) {
    if (trim($_POST['inputConfirmPassword']) == trim($_POST['inputPassword'])) {

    } else {
        $validinput = false;
        $querystring .= 'pwconfirm=notmatch&';
    }
} else {
    $validinput = false;
    $querystring .= 'pwconfirm=empty&';
}

// if every input is set with a value
if ($validinput == true) {
    require 'require/dbconn.php';
    // if the email exists before
    $stmt1 = $conn->prepare("select count(email) occurence from users where email=:email");
    $stmt1->execute(['email' => $email]);
    $count = $stmt1->fetch();
    if ($count['occurence'] > 0) {
        $conn = null;
        header('location:signup_form.php?msg=mailexist');
    } else {
        //insert prepared statement
        $stmt2 = $conn->prepare('insert into users(full_name, mobile, email, password) values(:fullname, :mobile, :email, :password)');
        $fullname = $fName . ' ' . $lName;
        $pass = password_hash($password, PASSWORD_BCRYPT);
        $stmt2->execute(['email' => $email, 'fullname' => $fullname, 'mobile' => $mobile, 'password' => $pass]);
        $conn = null;
        header('location:signup_form.php?user=' . $fName);
    }
} else {
    header('location:signup_form.php' . $querystring);
}


	