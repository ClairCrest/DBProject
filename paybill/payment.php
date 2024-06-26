<?php
session_start();
require_once '../config/db.php';

if(isset($_POST['pay'])) 
{
    $money = $_POST['money'];
    $billType = $_POST['bill_type']; // Retrieve the selected bill type

    if(empty($money))
    {
        $_SESSION['error'] = "กรุณากรอกจำนวนเงิน";
        header("location: ../paybill/index.php");
        exit();
    }
    else if(!filter_var($money, FILTER_VALIDATE_FLOAT)) 
    {
        $_SESSION['error'] = 'กรุณากรอกใหม่';
        header("location: ../paybill/index.php");
        exit();
    }
    else if($money < 0)
    {
        $_SESSION['error'] = 'กรุณากรอกใหม่';
        header("location: ../paybill/index.php");
        exit();
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
                exit();
            }
            else
            {
                $newBalance = $currentBalance - $money;

                // Update balance in the database
                $updateBalanceStmt = $conn->prepare("UPDATE users SET balance = :new_balance WHERE id = :user_id");
                $updateBalanceStmt->bindParam(":new_balance", $newBalance);
                $updateBalanceStmt->bindParam(":user_id", $_SESSION['user_login']);
                $updateBalanceStmt->execute();

                // Determine ref_id based on billType
                $ref_id = ($billType == "electricity") ? 3 : 4;
                

                // Store transaction history
                $insertHistoryStmt = $conn->prepare("INSERT INTO history (id, old_balance, new_balance, difference, ref_id, vat_type) VALUES (:user_id, :current_balance, :new_balance, :money, :ref_id, 'incountry')");
                $insertHistoryStmt->bindParam(":user_id", $_SESSION['user_login']);
                $insertHistoryStmt->bindParam(":current_balance", $currentBalance);
                $insertHistoryStmt->bindParam(":new_balance", $newBalance);
                $insertHistoryStmt->bindParam(":money", $money);
                $insertHistoryStmt->bindParam(":ref_id", $ref_id); // Use the determined ref_id
                $insertHistoryStmt->execute();

                // Redirect to success page
                $_SESSION['success'] = "ชำระสำเร็จ";
                header("location: ../paybill/index.php");
                exit();
            }  
        }
        catch(PDOException $e) 
        {
            echo $e->getMessage();
        }
    }
}
?>
