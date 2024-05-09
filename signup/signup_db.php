<?php
    session_start();
    require_once '../config/db.php';

    if(isset($_POST['signup'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $citizen_ID = $_POST['citizen_ID'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $province = $_POST['province'];
        $password = $_POST['pass$password'];
        $c_password = $_POST['c_password'];
        $urole = 'user';

        if(empty($firstname)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อ';
            header("location: ../signup/index.php");
        } 
        else if(empty($lastname)) {
            $_SESSION['error'] = 'กรุณากรอกนามสกุล';
            header("location: ../signup/index.php");
        } 
        else if(empty($citizen_ID)) {
            $_SESSION['error'] = 'กรุณากรอกเลขบัตรประชาชน';
            header("location: ../signup/index.php");
        } 
        else if(empty($telephone)) {
            $_SESSION['error'] = 'กรุณากรอกเบอร์โทรศัพท์';
            header("location: ../signup/index.php");
        } 
        else if(empty($email)) {
            $_SESSION['error'] = 'กรุณากรอกอีเมล';
            header("location: ../signup/index.php");
        } 
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            header("location: ../signup/index.php");
        }
        else if(empty($province)) {
            $_SESSION['error'] = 'กรุณากรอกที่อยู่';
            header("location: ../signup/index.php");
        }
        else if(empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: ../signup/index.php");
        }
        else if(strlen($_POST['password']) > 20 || strlen($_POST['password'] < 5)) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5-20 ตัวอักษร';
            header("location: ../signup/index.php");
        }
        else if(empty($c_password)) {
            $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
            header("location: ../signup/index.php");
        }
        else if($password != $c_password) {
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
            header("location: ../signup/index.php");
        } else{
            try {
                $check_email = $conn->prepare("SELECT email FROM user WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);

                if($row['email'] == $email) {
                    $_SESSION['warning'] = "มีอีเมลนี้อยู่ในระบบแล้ว <a href='../index.php'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: ../signup/index.php");
                } else if(!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO user(firstname, lastname, citizen_ID, telephone, email, province, password, urole) 
                                            VALUE():firstname, :lastname, :citizen_ID :telephone, :email, :province, :password, :urole");
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":citizen_ID", $citizen_ID);
                    $stmt->bindParam(":telephone", $telephone);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":province", $province);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":urole", $urole);
                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว <a href='../index.php' class='alert-link'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: ../signup/index.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: ../signup/index.php");
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

    }
?>