<?php 
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['moderator_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ';
    header("location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/assets/css/style.css" rel="stylesheet">
    <title>Analysis Report Tables</title>
</head>
<body>
    <div class="container text-white">
        <h1 class="mt-5">Analysis Report Tables</h1>

        <!-- Report 1: Total Transactions by User Role and Country -->
        <section class="mt-5">
            <h2>Total Transactions by User Role and Country</h2>
            <table class="table table-bordered table-light text-dark">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>User Role</th>
                        <th>Total Transactions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql1 = "SELECT a.country, u.urole, COUNT(*) AS total_transactions
                             FROM history h
                             INNER JOIN users u ON h.id = u.id
                             INNER JOIN acc_detail ad ON u.detail_id = ad.detail_id
                             INNER JOIN address1 a ON ad.address_id = a.address_id
                             GROUP BY a.country, u.urole
                             ORDER BY a.country, u.urole ASC";

                    $stmt1 = $conn->query($sql1);
                    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['country']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['urole']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_transactions']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <!-- Report 2: Average Transaction Value by Month and VAT Type -->
        <section class="mt-5">
            <h2>Average Transaction Value by Month and VAT Type</h2>
            <table class="table table-bordered table-light text-dark">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>VAT Percent</th>
                        <th>Average Transaction Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql2 = "SELECT MONTH(h.created_at) AS month, v.percent AS vat_percent, AVG(h.difference) AS avg_transaction_value
                             FROM history h
                             INNER JOIN vat v ON h.ref_id = v.vat_type
                             GROUP BY MONTH(h.created_at), v.percent
                             ORDER BY month ASC, vat_percent ASC";

                    $stmt2 = $conn->query($sql2);
                    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['month']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['vat_percent']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['avg_transaction_value']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <!-- Report 3: Users with Most Transactions by Country (Excluding Admins) -->
        <section class="mt-5">
            <h2>Users with Most Transactions by Country (Excluding Admins)</h2>
            <table class="table table-bordered table-light text-dark">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Email</th>
                        <th>Total Transactions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql3 = "SELECT a.country, u.email, COUNT(*) AS total_transactions
                             FROM history h
                             INNER JOIN users u ON h.id = u.id
                             INNER JOIN acc_detail ad ON u.detail_id = ad.detail_id
                             INNER JOIN address1 a ON ad.address_id = a.address_id
                             WHERE u.urole <> 'admin'
                             GROUP BY a.country, u.id
                             ORDER BY a.country, total_transactions DESC
                             LIMIT 10";

                    $stmt3 = $conn->query($sql3);
                    while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['country']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_transactions']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <!-- Report 4: Users with Zero Balance and Last Transaction Details -->
        <section class="mt-5">
            <h2>Users with Zero Balance and Last Transaction Details</h2>
            <table class="table table-bordered table-light text-dark">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Balance</th>
                        <th>Order ID</th>
                        <th>Difference</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql4 = "SELECT u.email, u.balance, h.order_id, h.difference
                             FROM users u
                             INNER JOIN history h ON u.id = h.id
                             WHERE u.balance = 0
                             ORDER BY u.email ASC";

                    $stmt4 = $conn->query($sql4);
                    while ($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['balance']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['difference']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <!-- Report 5: Transactions with Highest/Lowest Difference by User and Country -->
        <section class="mt-5">
            <h2>Transactions with Highest/Lowest Difference by User and Country</h2>
            <table class="table table-bordered table-light text-dark">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Email</th>
                        <th>Order ID</th>
                        <th>Difference</th>
                        <th>Transaction Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql5 = "SELECT a.country, u.email, h.order_id, h.difference, 
                                CASE WHEN h.difference > 0 THEN 'Increase' ELSE 'Decrease' END AS transaction_type
                             FROM history h
                             INNER JOIN users u ON h.id = u.id
                             INNER JOIN acc_detail ad ON u.detail_id = ad.detail_id
                             INNER JOIN address1 a ON ad.address_id = a.address_id
                             GROUP BY a.country, u.id
                             ORDER BY a.country, h.difference DESC, h.difference ASC
                             LIMIT 2";

                    $stmt5 = $conn->query($sql5);
                    while ($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['country']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['difference']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['transaction_type']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
