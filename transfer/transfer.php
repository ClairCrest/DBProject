<?php 
session_start();
require_once '../config/db.php';

if(isset($_POST['transfer'])) 
{
    $amount = $_POST['amount'];
    $account_no = $_POST['account_no'];
    if(empty($amount) || empty($account_no))
    {
        $_SESSION['error'] = 'กรุณากรอกข้อมูล';
        header("location: ../transfer/index.php");
    }
    else if(!filter_var($amount, FILTER_VALIDATE_FLOAT) || !filter_var($account_no, FILTER_VALIDATE_FLOAT))
    {
        $_SESSION['error'] = 'กรุณากรอกข้อมูลใหม่อีกครั้ง';
        header("location: ../transfer/index.php");
    }
    else if($amount < 0)
    {
        $_SESSION['error'] = 'กรุณากรอกจำนวนเงิน';
        header("location: ../transfer/index.php");
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

            if($currentBalance < $amount)
            {
                $_SESSION['error'] = 'กรุณาลองใหม่อีกครั้ง';
                header("location: ../transfer/index.php");
            }
            else
            {
                $newBalance = $currentBalance - $amount;

                // Update balance in the database
                $updateBalanceStmt = $conn->prepare("UPDATE users SET balance = :new_balance WHERE id = :user_id");
                $updateBalanceStmt->bindParam(":new_balance", $newBalance);
                $updateBalanceStmt->bindParam(":user_id", $_SESSION['user_login']);
                $updateBalanceStmt->execute();

                // Retrieve current balance from the database
                $getBalanceStmt = $conn->prepare("SELECT balance FROM users WHERE id = :user_id");
                $getBalanceStmt->bindParam(":user_id", $account_no);
                $getBalanceStmt->execute();
                $row2 = $getBalanceStmt->fetch(PDO::FETCH_ASSOC);
                $currentBalance2 = $row2['balance'];

                $newBalance2 = $currentBalance2 + $amount;
                
                // Update balance in the database
                $updateBalanceStmt = $conn->prepare("UPDATE users SET balance = :new_balance WHERE id = :user_id");
                $updateBalanceStmt->bindParam(":new_balance", $newBalance2);
                $updateBalanceStmt->bindParam(":user_id", $account_no);
                $updateBalanceStmt->execute();

                // Store transaction history
                $insertHistoryStmt = $conn->prepare("INSERT INTO history (id, target_id, old_balance, new_balance, difference, ref_id) VALUES (:user_id, :target_id, :current_balance, :new_balance, :amount, 'transfer')");
                $insertHistoryStmt->bindParam(":user_id", $_SESSION['user_login']);
                $insertHistoryStmt->bindParam(":target_id", $account_no);
                $insertHistoryStmt->bindParam(":current_balance", $currentBalance);
                $insertHistoryStmt->bindParam(":new_balance", $newBalance);
                $insertHistoryStmt->bindParam(":amount", $amount);
                $insertHistoryStmt->execute();

                // Redirect to success page
                $_SESSION['success'] = "ทำรายการสำเร็จ";
                header("location: ../transfer/index.php");
            }
        }
        catch(PDOException $e) 
        {
            echo $e->getMessage();
        }
    }
} 
?>