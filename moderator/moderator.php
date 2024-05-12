<?php
session_start();
require_once '../config/db.php';

// Initialize variables
$searchResults = '';
$searchCriteria = '';

if(isset($_POST['Search'])) {
    // Perform search
    $id = $_POST['id'];
    $query = "SELECT * FROM history WHERE id LIKE :id ORDER BY order_id ASC";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id', '%' . $id . '%');
    $stmt->execute();

    // Display search results
    if($stmt->rowCount() > 0) {
        $searchResults .= "<table border='1' align='center' class='table table-hover'>";
        $searchResults .= "<tr>";
        $searchResults .= "<td>"."No"."</td>";
        $searchResults .= "<td>"."ID"."</td>";
        $searchResults .= "<td>"."Target ID"."</td>";
        $searchResults .= "<td>"."Old Balance"."</td>";
        $searchResults .= "<td>"."New Balance"."</td>";
        $searchResults .= "<td>"."Difference"."</td>";
        $searchResults .= "<td>"."Created At"."</td>";
        $searchResults .= "<td>"."ReferenceID"."</td>";
        $searchResults .= "</tr>";
        
        $r = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $searchResults .= "<tr>";
            $searchResults .= "<td>".$r++."</td>";
            $searchResults .= "<td>".$row["id"]."</td>";
            $searchResults .= "<td>".$row["target_id"]."</td>";
            $searchResults .= "<td>".$row["old_balance"]."</td>";
            $searchResults .= "<td>".$row["new_balance"]."</td>";
            $searchResults .= "<td>".$row["difference"]."</td>";
            $searchResults .= "<td>".$row["created_at"]."</td>";
            $searchResults .= "<td>".$row["ref_id"]."</td>";
            $searchResults .= "</tr>";
        }
        $searchResults .= "</table>";
    } else {
        $searchResults = "No records found.";
    }

    // Store search criteria for display
    $searchCriteria = $_POST['id'];
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
        <form name="searchForm" method="post" action="">
            <div class="mb-3">
                <label for="id" class="form-label">ID:</label>
                <input type="text" class="form-control" id="id" name="id" value="<?php echo $searchCriteria; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="Search">Search</button>
        </form>
    </div>

    <div class="container">
        <h2>Search Results</h2>
        <?php echo $searchResults; ?>
    </div>
</body>
</html>
