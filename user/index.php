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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
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
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        ?>
        <!--<h1>Welcome <?php //echo $row['firstname']. ' ' .$row['lastname']?> User</h1>-->
        <div class="container mt-5">
        <h1>My Account <?php echo $row['firstname']. ' ' .$row['lastname']?> </h1>
        <div class="card mb-3 center">
        <div class="card-body">
            <div class="row">
            <div class="col-md-6">
                <h5 class="card-title">Balance</h5>
                <p class="card-text fs-1">$<span id="balance">999</span></p>
            </div>
            </div>
        </div>
        </div>
        <div class="container mt-5 row bottom-center">
        <div class="col-md-3 mx-5 my-2">
            <div class="card center action-card larger-card w-100">
            <h5 class="card-header">Transfer</h5>
            <div class="card-body">
                <p class="card-text">Transfer money to another account.</p>
                <a href="/transfer/" class="btn btn-primary">Transfer</a>
            </div>
            </div>
        </div>
        <div class="col-md-3 mx-5 my-2">
            <div class="card action-card larger-card w-100">
            <h5 class="card-header">Deposit</h5>
            <div class="card-body">
                <p class="card-text">Deposit your account balance.</p>
                <a href="/deposit/" class="btn btn-primary">Deposit</a>
            </div>
            </div>
        </div>
        <div class="col-md-3 mx-5 my-2">
            <div class="card action-card larger-card w-100">
            <h5 class="card-header">Pay Bill</h5>
            <div class="card-body">
                <p class="card-text">Pay your bills online.</p>
                <a href="/paybill/" class="btn btn-primary">Pay Bill</a>
            </div>
            </div>
        </div>
        <div class="col-md-3 mx-5 my-2">
            <div class="card action-card larger-card w-100">
            <h5 class="card-header">Withdraw</h5>
            <div class="card-body">    
                <p class="card-text">Withdraw money from your account.</p>
                <a href="#" class="btn btn-primary">Withdraw</a>
            </div>
            </div>
        </div>
        </div>
        <a href="../logout/" class="btn btn-danger">Log out</a>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    // Replace with your JavaScript to fetch balance data from MySQL database
    // and update the #balance element's content
    fetch('/get_balance.php')
      .then(response => response.json())
      .then(data => {
        document.getElementById('balance').textContent = data.balance;
      })
      .catch(error => console.error(error));
        </script>
</body>
</html>