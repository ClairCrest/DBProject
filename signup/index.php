<?php
  session_start();
  require_once '../config/db.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../assets/css/style.css" rel="stylesheet">
  </head>
  <body>
  <div class="container mt-3">
    <h1>KMUTT666 Registration</h1>
    <hr>
    <form action="../signup/signup_db.php" method="post"> 
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
            <?php if (isset($_SESSION['warning'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php
                        echo$_SESSION['warning'];
                        unset($_SESSION['warning']);
                    ?>
                </div>
            <?php } ?>
      <div class="row">
        <div class="col-md-6">
          <label for="firstname" class="form-label">Name</label>
          <input type="text" class="form-control" name="firstname" placeholder="Enter Firstname">
        </div>
        <div class="col-md-6">
          <label for="lastname" class="form-label">Lastname</label>
          <input type="text" class="form-control" name="lastname" placeholder="Enter Lastname">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mt-3">
          <label for="citizenID" class="form-label">CitizenID</label>
          <input type="text" class="form-control" name="citizen_ID" placeholder="Enter Citizen ID">
        </div>
        <div class="col-md-6 mt-3">
          <label for="telephone" class="form-label">Telephone</label>
          <input type="text" class="form-control" name="telephone" placeholder="Enter Telephone">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mt-3">
          <label for="province" class="form-label">Province</label>
          <input type="text" class="form-control" name="province" placeholder="Enter Province">
        </div>
        <div class="col-md-6 mt-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control"name="email" placeholder="Enter Email">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mt-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Enter Password">
        </div>
        <div class="col-md-6 mt-3">
          <label for="confirm_password" class="form-label">Confirm Password</label>
          <input type="password" class="form-control" name="c_password" placeholder="Confirm Password">
        </div>
      </div>
      <button type="submit" class="btn btn-primary mt-3 w-10" name="signup">Register</button>

    </form>
    <hr>
    <p>เป็นสมาชิกแล้วใช่ไหม คลิ๊กที่นี่เพื่อ<a href="../index.php">เข้าสู่ระบบ</a></p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>