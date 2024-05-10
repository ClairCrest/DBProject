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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pay bill</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
  <div class="position-absolute top-0 start-50 translate-middle-x mt-3 text-white w-25">
    <form action="../paybill/payment.php" method="post">
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
    <fieldset usabled>
      <legend>Pay bill</legend>
      <div class="mb-3">
        <label for="disabledTextInput" class="form-label">Payment</label>
        <input type="text" class="form-control" name="money" placeholder="Amount">
      </div>
      <div class="mb-3">
        <label for="disabledSelect" class="form-label">Select Option</label>
        <select id="disabledSelect" class="form-select">
          <option>Electricity</option>
          <option>Water</option>
        </select>
      </div>
      <a href="../user/" class="btn btn-danger">Back</a>
      <button type="submit" class="btn btn-primary" name="pay">Submit</button>
    </fieldset>
    </form>
  </div>
</body>
</html>
