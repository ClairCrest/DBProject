<?php
    session_start();
    require_once '../config/db.php';
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
    <title>Deposit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="position-absolute top-50 start-50 text-center translate-middle">
        <form action="../deposit/deposit.php" method="post">
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
            <fieldset usabled class="text-white">
                <legend>Deposit</legend>
                <img width='300' height='300' src='../assets/img/deposit1.jpg' alt='' class="rounded" class='deposit1'>
                <div class="mt-3 mb-3">
                    <input type="text" class="form-control text-center" name="money" placeholder="Add Money">
                </div>
                <a href="../user/" class="me-5 btn btn-danger">Back</a>
                <button type="submit" class="ms-5 btn btn-primary" name="deposit">Deposit</button>
            </fieldset>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>