<?php
session_start();
require_once '../config/db.php';

if(isset($_POST['deposit'])) 
{
    $money = $_POST['money']
} 
?>