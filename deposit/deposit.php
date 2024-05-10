<?php
session_start();
require_once '../config/db.php';

if(isset($_POST['deposit'])) 
{
    $money = $_POST['money'];
    if(empty($money))
    {
        $_SESSION['error'] = "กรุณากรอกจำนวนเงิน";
        header("location: ../deposit/index.php");
    }
    else if (!filter_var($money, FILTER_VALIDATE_FLOAT)) 
    {
        $_SESSION['error'] = 'กรุณากรอกใหม่';
        header("location: ../deposit/index.php");
    }
    else
    {
        try
            {


            }catch(PDOException $e) 
            {
                echo $e->getMessage();
            }
        }
    } 
?>