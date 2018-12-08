<?php

$fname = "";
$lname = "";
$mobile = "";
$email = "";

if (!empty($_GET["fname"])) {
    $fname = $_GET["fname"];
}
if (!empty($_GET["lname"])) {
    $lname = $_GET["lname"];
}
if (!empty($_GET["mobile"])) {
    $mobile = $_GET["mobile"];
}
if (!empty($_GET["email"])) {
    $email = $_GET["email"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>sign up form</title>
    <!-- Bootstrap core CSS -->
    <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Parsley core CSS -->
    <link href="libs/parsley/parsley.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="customstyles/signin.css" rel="stylesheet">
    <style>
        .req{
            color: red;
        }
    </style>
</head>
<body class="text-center" style="background-color: azure">
<form name="signupform" id="signupform" method="post" action="signup.php" class="form-signin" data-parsley-validate>
    <?php
    if (!empty($_GET['msg'])) {
        if ($_GET['msg'] == 'mailexist') {
            ?>
            <div class="alert alert-danger">This Email already exists..</div>
            <?php
        }
    } elseif (!empty($_GET['user'])) {
        ?>
        <div class="alert alert-success">User <?php echo $_GET['user']; ?> added successfully</div>
        <?php
    }
    ?>
    <img class="mb-4" src="imgs/cart.png" alt="" width="100" height="100">

    <h1 class="h4 mb-3 font-weight-normal">Please sign up</h1>
    <label for="inputFirstName" class="sr-only">First name</label>
    <input required type="text" id="inputFirstName" name="inputFirstName" value="<?php echo $fname ?>"
           class="form-control" placeholder="First name"
           autofocus>
    <span class="req">
        <?php
        if (!empty($_GET["fname"])) {
            if ($_GET["fname"] == "empty") {
                echo "First Name is Required Field";
            }
        }
        ?>
    </span>
    <label for="inputLastName" class="sr-only">Last name</label>
    <input required type="text" id="inputLastName" name="inputLastName" value="<?php echo $lname ?>"
           class="form-control"
           placeholder="Last name">
    <span class="req">
         <?php
         if (!empty($_GET["lname"])) {
             if ($_GET["lname"] == "empty") {
                 echo "Last Name is Required Field";
             }
         }
         ?>
    </span>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input required type="email" id="inputEmail" name="inputEmail" value="<?php echo $email ?>" class="form-control"
           placeholder="Email address">
    <span class="req">
        <?php
        if(!empty($_GET["email"]))
        {
            if($_GET["email"]=="empty") echo "Email is Required Field";
            else if($_GET["email"] =="not_valid")echo "Email is Not valid Format";
        }
        ?>
    </span>
    <label for="inputMobile" class="sr-only">Mobile</label>
    <input required type="number" id="inputMobile" name="inputMobile" value="<?php echo $mobile ?>" class="form-control"
           placeholder="Mobile number">
    <span class="req">
        <?php
        if (!empty($_GET["mobile"])) {
            if ($_GET["mobile"] == "empty") {
                echo "Mobile is Required Field";
            }
        }
        ?>
    </span>
    <p class="mt-5 mb-3 text-muted" onclick="addcontact()">
        <span class="glyphicon glyphicon-plus-sign"></span>
        add another contact
    </p>
    <div id="contact"></div>
    <label for="inputPassword" class="sr-only">Password</label>
    <input required type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password">
    <span class="req">
        <?php
        if (!empty($_GET["pw"])) {
            if ($_GET["pw"] == "empty") {
                echo "Password is Required Field";
            }
        }
        ?>
    </span>
    <label for="inputConfirmPassword" class="sr-only">Confirm password</label>
    <input required data-parsley-equalto="#inputPassword" type="password" id="inputConfirmPassword"
           name="inputConfirmPassword" class="form-control" placeholder="Confirm password">
    <span class="req">
        <?php
        if(!empty($_GET["pwconfirm"] ))
        {
            if(   $_GET["pwconfirm"]=="empty")
                echo "Confirm Password is Required Field";
            else if($_GET["pwconfirm"] == "notmatch")
                echo "Password and Confirm password not matching";
        }
        ?>
    </span>
    <button class="btn btn-lg btn-success btn-block" type="submit">Sign up</button>
    <a class="btn btn-lg btn-primary btn-block" href="index.php">Sign in</a>

    <p class="mt-5 mb-3 text-muted">&copy; E-commerce Project</p>
</form>

<!-- Script for Jquery -->
<script src="libs/jquery/jquery.min.js"></script>
<!-- Script for Parsley -->
<script src="libs/parsley/parsley.min.js"></script>
<script src="customjs/addcontact.js"></script>
</body>
</html>