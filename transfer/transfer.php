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
        $transferType = $_POST['transfer_type'];

// Adjust amount based on transfer type
        if ($transferType === "oversea") {
    // Subtract 10% from the amount for oversea transfer
            $amount = $amount * 0.9; // 10% deduction
            $vatType = "oversea";
        } else {
            $vatType = "incountry";
        }

            try {
    // Retrieve current balance from the database
            $getBalanceStmt = $conn->prepare("SELECT balance FROM users WHERE id = :user_id");
            $getBalanceStmt->bindParam(":user_id", $_SESSION['user_login']);
            $getBalanceStmt->execute();
            $row = $getBalanceStmt->fetch(PDO::FETCH_ASSOC);
            $currentBalance = $row['balance'];

    // Check if the user has sufficient balance
            if ($currentBalance < $amount) {
                $_SESSION['error'] = 'ไม่สามารถทำรายการได้ เงินในบัญชีไม่เพียงพอ';
                header("location: ../transfer/index.php");
                exit(); // Stop script execution
            }

    // Calculate new balance
            $newBalance = $currentBalance - $amount;

    // Update balance in the user's account
            $updateBalanceStmt = $conn->prepare("UPDATE users SET balance = :new_balance WHERE id = :user_id");
            $updateBalanceStmt->bindParam(":new_balance", $newBalance);
            $updateBalanceStmt->bindParam(":user_id", $_SESSION['user_login']);
            $updateBalanceStmt->execute();

    // Retrieve current balance from the database for the target account
            $getBalanceStmt = $conn->prepare("SELECT balance FROM users WHERE id = :user_id");
            $getBalanceStmt->bindParam(":user_id", $account_no);
            $getBalanceStmt->execute();
            $row2 = $getBalanceStmt->fetch(PDO::FETCH_ASSOC);
            $currentBalance2 = $row2['balance'];

            $newBalance2 = $currentBalance2 + $amount;

    // Update balance in the target account
            $updateBalanceStmt = $conn->prepare("UPDATE users SET balance = :new_balance WHERE id = :user_id");
            $updateBalanceStmt->bindParam(":new_balance", $newBalance2);
            $updateBalanceStmt->bindParam(":user_id", $account_no);
            $updateBalanceStmt->execute();

    // Store transaction history
            $insertHistoryStmt = $conn->prepare("INSERT INTO history (id, target_id, old_balance, new_balance, difference, ref_id, vat_type) VALUES (:user_id, :target_id, :current_balance, :new_balance, :amount, 'transfer', :vat_type)");
            $insertHistoryStmt->bindParam(":user_id", $_SESSION['user_login']);
            $insertHistoryStmt->bindParam(":target_id", $account_no);
            $insertHistoryStmt->bindParam(":current_balance", $currentBalance);
            $insertHistoryStmt->bindParam(":new_balance", $newBalance);
            $insertHistoryStmt->bindParam(":amount", $amount);
            $insertHistoryStmt->bindParam(":vat_type", $vatType);
            $insertHistoryStmt->execute();

    // Redirect to success page
            $_SESSION['success'] = "ทำรายการสำเร็จ";
    header("location: ../transfer/index.php");
    exit(); // Stop script execution
        } catch (PDOException $e) {
            echo $e->getMessage();
            }
        }
    }
?>