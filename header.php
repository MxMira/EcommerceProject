<?php
session_start();
require 'userClass.php';
if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
} else {
    header("location:index.php?msg=signin");
    return;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>MainPage</title>

    <!-- Favicons -->
    <link href="imgs/cart.png" rel="icon">

    <!-- Bootstrap core CSS -->
    <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Parsley core CSS -->
    <link href="libs/parsley/parsley.css" rel="stylesheet">
    <!--external css-->
    <link href="libs/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="customstyles/style.css" rel="stylesheet">
    <link href="customstyles/style-responsive.css" rel="stylesheet">
    <style>
        .req{
            color: red;
        }
    </style>
</head>

<body>
<section id="container">
    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
*********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg">
        <!--logo start-->
        <a href="mainpage.php" class="logo"><b>NH<span>SouQ</span></b></a>
        <!--logo end-->
        <div class="top-menu">
            <ul class="nav pull-right top-menu">
                <li><a class="logout" href="signout.php">Logout</a></li>
            </ul>
        </div>
    </header>
    <!--header end-->
    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
*********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <aside>
        <div id="sidebar">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
                <h5 class="centered"><?php echo $user->full_name ?></h5>
                <li class="mt">
                    <a <?php if($pageName == 'dashboard') echo "class='active'"?> href="mainpage.php">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="mt">
                    <a <?php if($pageName == 'manage') echo "class='active'"?> href="manage.php">
                        <i class="fa fa-users"></i>
                        <span>Manage Users</span>
                    </a>
                </li>
            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->
