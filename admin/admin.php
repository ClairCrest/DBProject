<?php
session_start();
require_once '../config/db.php';

// Function to display users
function displayUsers($conn)
{
    $query = "SELECT * FROM users";
    $stmt = $conn->query($query);
    $r = 1;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $r++ . "</td>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["firstname"] . "</td>";
        echo "<td>" . $row["lastname"] . "</td>";
        echo "<td>" . $row["citizen_ID"] . "</td>";
        echo "<td>" . $row["telephone"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["province"] . "</td>";
        echo "<td>" . $row["created_at"] . "</td>";
        echo "</tr>";
    }
}

// Function to delete user
function deleteUser($conn, $userId)
{
    $query = "DELETE FROM users WHERE id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo "Delete success";
    } else {
        echo "Delete failed";
    }
}

// Initialize variables
$searchResults = '';
$searchCriteria = '';

if (isset($_POST['Search'])) {
    // Perform search
    $id = $_POST['id'];
    $query = "SELECT * FROM users WHERE id LIKE :id ORDER BY id ASC";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id', '%' . $id . '%');
    $stmt->execute();

    // Display search results
    if ($stmt->rowCount() > 0) {
        $searchResults .= "<table border='1' align='center' class='table table-hover'>";
        $searchResults .= "<tr>";
        $searchResults .= "<td>" . "No" . "</td>";
        $searchResults .= "<td>" . "ID" . "</td>";
        $searchResults .= "<td>" . "First Name" . "</td>";
        $searchResults .= "<td>" . "Last Name" . "</td>";
        $searchResults .= "<td>" . "Citizen ID" . "</td>";
        $searchResults .= "<td>" . "Telephone" . "</td>";
        $searchResults .= "<td>" . "Email" . "</td>";
        $searchResults .= "<td>" . "Province" . "</td>";
        $searchResults .= "<td>" . "Created At" . "</td>";
        $searchResults .= "</tr>";

        $r = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $searchResults .= "<tr>";
            $searchResults .= "<td>" . $r++ . "</td>";
            $searchResults .= "<td>" . $row["id"] . "</td>";
            $searchResults .= "<td>" . $row["firstname"] . "</td>";
            $searchResults .= "<td>" . $row["lastname"] . "</td>";
            $searchResults .= "<td>" . $row["citizen_ID"] . "</td>";
            $searchResults .= "<td>" . $row["telephone"] . "</td>";
            $searchResults .= "<td>" . $row["email"] . "</td>";
            $searchResults .= "<td>" . $row["province"] . "</td>";
            $searchResults .= "<td>" . $row["created_at"] . "</td>";
            $searchResults .= "</tr>";
        }
        $searchResults .= "</table>";
    } else {
        $searchResults = "No records found.";
    }

    // Store search criteria for display
    $searchCriteria = $_POST['id'];
}

// Process user deletion
if (isset($_POST['Delete'])) {
    $userId = $_POST['deleteId'];
    deleteUser($conn, $userId);
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
        if (isset($_SESSION['admin_login'])) {
            // Query data to find user information
            $admin_id = $_SESSION['admin_login'];
            $stmt = $conn->query("SELECT * FROM users WHERE id = $admin_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        ?>
        <h1>Welcome Admin <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></h1>
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

    <div class="container">
        <h2>Delete User</h2>
        <form name="deleteForm" method="post" action="">
            <div class="mb-3">
                <label for="deleteId" class="form-label">Enter ID to Delete:</label>
                <input type="text" class="form-control" id="deleteId" name="deleteId">
            </div>
            <button type="submit" class="btn btn-danger" name="Delete">Delete</button>
        </form>
    </div>
</body>

</html>
