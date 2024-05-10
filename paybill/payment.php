<?php
session_start();
require_once '../config/db.php';

if(isset($_POST['pay'])) 
{
    $money = $_POST['money'];
    if(empty($money))
    {
        $_SESSION['error'] = "กรุณากรอกจำนวนเงิน";
        header("location: ../paybill/index.php");
    }
    else if(!filter_var($money, FILTER_VALIDATE_FLOAT)) 
    {
        $_SESSION['error'] = 'กรุณากรอกใหม่';
        header("location: ../paybill/index.php");
    }
    else if($money < 0)
    {
        $_SESSION['error'] = 'กรุณากรอกใหม่';
        header("location: ../paybill/index.php");
    }
    else
    {
        try
        {
            // Retrieve current balance from the database
            $getBalanceStmt = $conn->prepare("SELECT balance FROM users WHERE id = :user_id");
            $getBalanceStmt->bindParam(":user_id", $_SESSION['user_login']);
            $getBalanceStmt->execute();
            $row = $getBalanceStmt->fetch(PDO::FETCH_ASSOC);
            $currentBalance = $row['balance'];

            if($currentBalance < $money)
            {
                $_SESSION['error'] = 'กรุณาลองใหม่อีกครั้ง';
                header("location: ../paybill/index.php");
            }
            else
            {
                $newBalance = $currentBalance - $money;

                // Update balance in the database
                $updateBalanceStmt = $conn->prepare("UPDATE users SET balance = :new_balance WHERE id = :user_id");
                $updateBalanceStmt->bindParam(":new_balance", $newBalance);
                $updateBalanceStmt->bindParam(":user_id", $_SESSION['user_login']);
                $updateBalanceStmt->execute();

                // Store transaction history
                $insertHistoryStmt = $conn->prepare("INSERT INTO history (id, old_balance, new_balance, difference) VALUES (:user_id, :current_balance, :new_balance, :money)");
                $insertHistoryStmt->bindParam(":user_id", $_SESSION['user_login']);
                $insertHistoryStmt->bindParam(":current_balance", $currentBalance);
                $insertHistoryStmt->bindParam(":new_balance", $newBalance);
                $insertHistoryStmt->bindParam(":money", $money);
                $insertHistoryStmt->execute();

                // Redirect to success page
                $_SESSION['success'] = "ชำระสำเร็จ";
                header("location: ../paybill/index.php");
            }
        }
        catch(PDOException $e) 
        {
            echo $e->getMessage();
        }
    }
} 
?>
