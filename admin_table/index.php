<?php 
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ';
    header("location: ../index.php");
    exit();
}

try {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $conn = new PDO("mysql:host=$servername;dbname=transaction", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Delete user if ID is provided in POST request
    if (isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];
        // First, delete the user details from acc_detail table
        $stmt = $conn->prepare("DELETE FROM acc_detail WHERE detail_id = (SELECT detail_id FROM users WHERE id = :id)");
        $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
        $stmt->execute();

        // Then, delete the user from users table
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['success'] = 'User deleted successfully';
        header("location: index.php");
        exit();
    }

    // Fetch user details with role_id = 3
    $stmt = $conn->prepare("
        SELECT u.id, u.email, u.balance, ad.firstname, ad.lastname, ad.citizen_ID, ad.telephone 
        FROM users u 
        JOIN acc_detail ad ON u.detail_id = ad.detail_id 
        WHERE u.role_id = 3
    ");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
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
    <div class="container mt-5 text-white">
        <h2>User Details (Role ID = 3)</h2>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Balance</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Citizen ID</th>
                    <th>Telephone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['balance']); ?></td>
                            <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                            <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($user['citizen_ID']); ?></td>
                            <td><?php echo htmlspecialchars($user['telephone']); ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No users found with role ID = 3.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="../admin/" class="btn btn-danger">Back</a>
    </div>
</body>
</html>
