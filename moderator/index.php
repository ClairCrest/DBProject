<?php 
    session_start();
    require_once  '../config/db.php';
    if(!isset($_SESSION['moderator_login']))
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
    <title>Moderator Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php 
            if(isset($_SESSION['moderator_login']))
            {
                //เอาไว้ query data หาข้อมูล
                $moderator_id = $_SESSION['moderator_login'];
                $stmt = $conn->query("SELECT * FROM users WHERE id = $moderator_id");
                $stmt-> execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        ?>
        <h1>Welcome Moderator <?php echo $row['firstname']. ' ' .$row['lastname']?></h1>
        <a href="../logout/" class="btn btn-danger">Log out</a>
    </div>

    <div class="container">
        <h2>Search Form</h2>
        <form name="searchForm" method="post" action="moderator.php">
            <div class="mb-3">
                <label for="id" class="form-label">ID:</label>
                <input type="text" class="form-control" id="id" name="id">
            </div>
            <button type="submit" class="btn btn-primary" name="Search">Search</button>
        </form>
    </div>
    
</body>
</html>


