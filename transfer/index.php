<?php 
    session_start();
    require_once  '../config/db.php';
    if(!isset($_SESSION['user_login']))
    {
        $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ';
        header("location: ../index.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
    <?php 
        if(isset($_SESSION['user_login']))
        {
            //เอาไว้ query data หาข้อมูล
            $user_id = $_SESSION['user_login'];
            $stmt = $conn->query("SELECT * FROM users WHERE id = $user_id");
            $stmt-> execute();
            $row2 = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    ?>  
    <form action="../transfer/transfer.php" method="post">
            <?php if (isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php
                            echo$_SESSION['error'];
                            unset($_SESSION['error']);
                        ?>
                    </div>
                <?php } ?>
                <?php if (isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php
                            echo$_SESSION['success'];
                            unset($_SESSION['success']);
                        ?>
                    </div>
            <?php } ?>
    <div class="container d-flex justify-content-center align-items-center vh-100"> 
        <div class="position-absolute top-0 start-50 translate-middle-x">
            <div class="my-5 text-white">
                <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Balance</h5>
                            <p class="card-text fs-1">฿<span id="balance"><?php echo number_format($row2['balance'],2)?></span></p>
                        </div>
                        </div>
                <h2 class="text-center ">Transfer To</h2>
                <div class="row">
                    <div class="col-md-auto">
                        <input type="text" class="form-control mx-3" id="Account_No" name="account_no" placeholder="Account No">
                    </div>
                </div>

                <h2 class="text-center mt-5">Amount</h2>
                <div class="row">
                    <div class="col-md-auto">
                        <input type="text" class="form-control mx-3" id="Amount" name="amount" placeholder="Amount">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-5">
                        <a class="btn btn-danger btn-primary w-100 mx-1" href="/user/" role="button">Back</a>
                    </div>
                    <div class="col-md-5">
                        <button type="submit" class="ms-5 btn btn-primary" name="transfer">Transfer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
