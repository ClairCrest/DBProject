<?php 
    session_start();
    unset($_SESSION['user_login']);
    unset($_SESSION['admin_login']);
    unset($_SESSION['moderator_login']);
    header("location: ../index.php")
?>