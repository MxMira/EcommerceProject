<?php
session_start();
if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
} else {
    header("location:index.php?msg=signin");
}