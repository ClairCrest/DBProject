<?php 
    session_start();
    require_once  '../config/db.php';
    if(!isset($_SESSION['admin_login']))
    {
        $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ';
        header("location: ../index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php 
            if(isset($_SESSION['admin_login']))
            {
                //เอาไว้ query data หาข้อมูล
                $admin_id = $_SESSION['admin_login'];
                $stmt = $conn->query("SELECT * FROM acc_detail WHERE detail_id = $admin_id");
                $stmt-> execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $admin_id = $_SESSION['admin_login'];
                $stmt = $conn->query("SELECT * FROM users WHERE id = $admin_id");
                $stmt-> execute();
                $row2 = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        ?>
        <!--<h1>Welcome <?php //echo $row['firstname']. ' ' .$row['lastname']?> User</h1>-->
        <div class="container mt-5">
            <h1 class="text-white">Welcome Admin: <?php echo $row['firstname'].' '.$row['lastname']?></h1>
            <h4 class="text-white">Account Num: <?php echo $row2['id']?> </h4>
            <div class="card mb-3 center">
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-6">
                        <h5 class="card-title">Balance</h5>
                        <p class="card-text fs-1">฿<span id="balance"><?php echo number_format($row2['balance'],2)?><img src="../assets/img/JT.jpg" alt="" class="lol_pic"></span></p>
                    </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card">
                        <h5 class="card-header">Analysis Report</h5>
                        <div class="card-body">
                            <p class="card-text">View all analysis</p>
                            <a href="/admin_analysis/" class="btn btn-warning">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <h5 class="card-header">User Table</h5>
                        <div class="card-body">
                            <p class="card-text">View User Table</p>
                            <a href="/admin_table/" class="btn btn-warning">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-10 mt-5 mx-2"><a href="../logout/" class="btn btn-danger">Log out</a></div>
    </div>
            
    
</body>
</html>