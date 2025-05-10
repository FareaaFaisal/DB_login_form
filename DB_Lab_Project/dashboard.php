<?php
session_start();

// to Check if user is logged in, if not, redirecting user to login page
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}
?>


