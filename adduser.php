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

// if every input is set with a value
if ($validinput == true) {
    $role= $_POST['inputrole'];
    $status= $_POST['inputstatus'];
    require 'require/dbconn.php';
    // if the email exists before
    $stmt1 = $conn->prepare("select count(email) occurence from users where email=:email");
    $stmt1->execute(['email' => $email]);
    $count = $stmt1->fetch();
    if ($count['occurence'] > 0) {
        $conn = null;
        header('location:manage.php?msg=mailexist');
    } else {
        //insert prepared statement
        $stmt2 = $conn->prepare('insert into users(full_name, mobile, email, password, role, status) values(?,?,?,?,?,?)');
        $fullname = ucfirst($fName) . ' ' . ucfirst($lName);
        $pass = md5('123');
        $stmt2->execute([$fullname,$mobile,$email,$pass,$role,$status]);
        $stmt2->errorInfo();
        $conn = null;
        // sending mail if pending
        if($status == 'Pending'){
            require_once 'phpmailer/send_email.php';
            my_email(
                "Hello,<br>
                   Welcome to your new Ecommerce account.<br>
                   You can log in right away and start using your new account.<br>
                   Please take a moment to confirm your email address with us.<br>
                   To confirm your email address, please click on the link below:<br>
                   <a href='http://localhost:8080/newhorizon/project/index.php'>Redirect to Reset Password</a><br>
                   Thank you,",
                "Ecommerce@gmail.com",
                "technical Support" ,
                $email,
                $fullname,
                "Reset Password Ecommerce"
            );
        }
        header('location:manage.php?user=' . $fName);
    }
} else {
    header('location:manage.php' . $querystring);
}


	