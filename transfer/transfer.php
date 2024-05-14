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
    else if(!filter_var($amount, FILTER_VALIDATE_FLOAT) || !filter_var($account_no, FILTER_VALIDATE_INT))
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
        try {
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $conn = new PDO("mysql:host=$servername;dbname=transaction", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Retrieve current balance from the database
            $user_id = $_SESSION['user_login'];
            $getBalanceStmt = $conn->prepare("SELECT balance, detail_id FROM users WHERE id = :user_id");
            $getBalanceStmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $getBalanceStmt->execute();
            $row = $getBalanceStmt->fetch(PDO::FETCH_ASSOC);
            $currentBalance = $row['balance'];
            $senderDetailId = $row['detail_id'];

            // Retrieve the address for the sender
            $getSenderCountryStmt = $conn->prepare("SELECT a.country FROM acc_detail ad JOIN address1 a ON ad.address_id = a.address_id WHERE ad.detail_id = :detail_id");
            $getSenderCountryStmt->bindParam(":detail_id", $senderDetailId, PDO::PARAM_INT);
            $getSenderCountryStmt->execute();
            $senderCountry = $getSenderCountryStmt->fetchColumn();

            // Retrieve the target's balance and detail_id from the database
            $getBalanceStmt = $conn->prepare("SELECT balance, detail_id FROM users WHERE id = :target_id");
            $getBalanceStmt->bindParam(":target_id", $account_no, PDO::PARAM_INT);
            $getBalanceStmt->execute();
            $row2 = $getBalanceStmt->fetch(PDO::FETCH_ASSOC);
            $currentBalance2 = $row2['balance'];
            $recipientDetailId = $row2['detail_id'];

            // Retrieve the address for the recipient
            $getRecipientCountryStmt = $conn->prepare("SELECT a.country FROM acc_detail ad JOIN address1 a ON ad.address_id = a.address_id WHERE ad.detail_id = :detail_id");
            $getRecipientCountryStmt->bindParam(":detail_id", $recipientDetailId, PDO::PARAM_INT);
            $getRecipientCountryStmt->execute();
            $recipientCountry = $getRecipientCountryStmt->fetchColumn();

            // Check if both users are in Thailand
            $transferType = 'incountry';
            if ($senderCountry !== 'Thailand' || $recipientCountry !== 'Thailand') {
                $transferType = 'oversea';
                $amount *= 1.1; // Apply 10% increase for oversea transfers
            }

            // Check if the user has sufficient balance
            if ($currentBalance < $amount) {
                $_SESSION['error'] = 'ไม่สามารถทำรายการได้ เงินในบัญชีไม่เพียงพอ';
                header("location: ../transfer/index.php");
                exit(); // Stop script execution
            }

            // Calculate new balances
            $newBalance = $currentBalance - $amount;
            $newBalance2 = $currentBalance2 + $_POST['amount']; // Add the original amount to the recipient's balance

            // Update balance in the user's account
            $updateBalanceStmt = $conn->prepare("UPDATE users SET balance = :new_balance WHERE id = :user_id");
            $updateBalanceStmt->bindParam(":new_balance", $newBalance, PDO::PARAM_STR);
            $updateBalanceStmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $updateBalanceStmt->execute();

            // Update balance in the target account
            $updateBalanceStmt = $conn->prepare("UPDATE users SET balance = :new_balance WHERE id = :user_id");
            $updateBalanceStmt->bindParam(":new_balance", $newBalance2, PDO::PARAM_STR);
            $updateBalanceStmt->bindParam(":user_id", $account_no, PDO::PARAM_INT);
            $updateBalanceStmt->execute();

            // Store transaction history
            $insertHistoryStmt = $conn->prepare("INSERT INTO history (id, target_id, old_balance, new_balance, difference, ref_id, vat_type) VALUES (:user_id, :target_id, :current_balance, :new_balance, :amount, :ref_id, :vat_type)");
            $ref_id = ($transferType === 'oversea' ? 6 : 5);
            $insertHistoryStmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $insertHistoryStmt->bindParam(":target_id", $account_no, PDO::PARAM_INT);
            $insertHistoryStmt->bindParam(":current_balance", $currentBalance, PDO::PARAM_STR);
            $insertHistoryStmt->bindParam(":new_balance", $newBalance, PDO::PARAM_STR);
            $insertHistoryStmt->bindParam(":amount", $amount, PDO::PARAM_STR);
            $insertHistoryStmt->bindParam(":ref_id", $ref_id, PDO::PARAM_INT);
            $insertHistoryStmt->bindParam(":vat_type", $transferType, PDO::PARAM_STR);
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