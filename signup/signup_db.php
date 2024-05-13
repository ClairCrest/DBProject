<?php
    session_start();
    require_once '../config/db.php';

    if(isset($_POST['signup'])) {
        $balance = 0;
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $citizen_ID = $_POST['citizen_ID'];
        $telephone = $_POST['telephone'];
        $province = $_POST['province'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $zip_code = $_POST['zip_code'];
        $country = $_POST['country'];
        $urole = 'user';

        if(empty($firstname) || empty($lastname) || empty($citizen_ID) || empty($telephone) || empty($province) || empty($email) || empty($password) || empty($c_password) || empty($country) || empty($zip_code)) {
            $_SESSION['error'] = 'Please fill in all fields';
            header("location: ../signup/index.php");
            exit();
        }

        if(strlen($_POST['citizen_ID']) !== 13) {
            $_SESSION['error'] = 'Invalid Citizen ID length';
            header("location: ../signup/index.php");
            exit();
        }

        if(strlen($_POST['telephone']) !== 10) {
            $_SESSION['error'] = 'Invalid Telephone number length';
            header("location: ../signup/index.php");
            exit();
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Invalid email format';
            header("location: ../signup/index.php");
            exit();
        }

        if(strlen($_POST['password']) < 5 || strlen($_POST['password']) > 20) {
            $_SESSION['error'] = 'Password length must be between 5 and 20 characters';
            header("location: ../signup/index.php");
            exit();
        }

        if($password !== $c_password) {
            $_SESSION['error'] = 'Passwords do not match';
            header("location: ../signup/index.php");
            exit();
        }

        try {
            // Check if email already exists
            $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
            $check_email->bindParam(":email", $email);
            $check_email->execute();
            $row_email = $check_email->fetch(PDO::FETCH_ASSOC);

            if($row_email['email'] == $email) {
                $_SESSION['error'] = "Email already exists";
                header("location: ../signup/index.php");
                exit();
            }

            // Insert data into acc_detail table
            $stmt_detail = $conn->prepare("INSERT INTO address1(country, province, zip_code) VALUES (:country, :province, :zip_code)");
            $stmt_detail->bindParam(":country", $country);
            $stmt_detail->bindParam(":province", $province);
            $stmt_detail->bindParam(":zip_code", $zip_code);
            $stmt_detail->execute();
            $address_id = $conn->lastInsertId(); // Get the last inserted ID

            // Insert data into acc_detail table
            $stmt_detail = $conn->prepare("INSERT INTO acc_detail (firstname, lastname, citizen_ID, telephone, address_id) VALUES (:firstname, :lastname, :citizen_ID, :telephone, :address_id)");
            $stmt_detail->bindParam(":firstname", $firstname);
            $stmt_detail->bindParam(":lastname", $lastname);
            $stmt_detail->bindParam(":citizen_ID", $citizen_ID);
            $stmt_detail->bindParam(":telephone", $telephone);
            $stmt_detail->bindParam(":address_id", $address_id);
            $stmt_detail->execute();
            $detail_id = $conn->lastInsertId(); // Get the last inserted ID

            // Insert data into users table
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt_users = $conn->prepare("INSERT INTO users (balance, email, password, urole, detail_id) VALUES (:balance, :email, :password, :urole, :detail_id)");
            $stmt_users->bindParam(":balance", $balance);
            $stmt_users->bindParam(":email", $email);
            $stmt_users->bindParam(":password", $passwordHash);
            $stmt_users->bindParam(":urole", $urole);
            $stmt_users->bindParam(":detail_id", $detail_id);
            $stmt_users->execute();

            $_SESSION['success'] = "Registration successful. <a href='../index.php' class='alert-link'>Click here</a> to login.";
            header("location: ../signup/index.php");
            exit();

        } catch(PDOException $e) {
            $_SESSION['error'] = "An error occurred: " . $e->getMessage();
            header("location: ../signup/index.php");
            exit();
        }
    }
?>