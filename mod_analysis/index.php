<?php 
    session_start();
    require_once '../config/db.php';
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
    <title>Admin Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container text-white">
        <h1 class="mt-5">Analysis Report Tables</h1>
        <div class="row mt-3">
            <div class="col-md-6">
                <h2>1. Country Transaction Analysis</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th>Transaction Type</th>
                            <th>Total Transactions</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Query to get country-wise transaction analysis
                            $query1 = "SELECT a.country, r.transaction_type, COUNT(h.order_id) AS total_transactions, SUM(h.difference) AS total_amount
                                       FROM address1 a
                                       INNER JOIN acc_detail ad ON a.address_id = ad.address_id
                                       INNER JOIN users u ON ad.detail_id = u.detail_id
                                       INNER JOIN history h ON u.id = h.id
                                       INNER JOIN reference r ON h.ref_id = r.ref_id
                                       GROUP BY a.country, r.transaction_type";
                            $stmt1 = $conn->query($query1);
                            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $row1['country'] . "</td>";
                                echo "<td>" . $row1['transaction_type'] . "</td>";
                                echo "<td>" . $row1['total_transactions'] . "</td>";
                                echo "<td>" . $row1['total_amount'] . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <h2>2. User Transaction Analysis</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Total Transactions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Query to get user-wise transaction analysis
                            $query2 = "SELECT ad.detail_id, COUNT(h.order_id) AS total_transactions
                                       FROM acc_detail ad
                                       LEFT JOIN users u ON ad.detail_id = u.detail_id
                                       LEFT JOIN history h ON u.id = h.id
                                       GROUP BY ad.detail_id";
                            $stmt2 = $conn->query($query2);
                            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $row2['detail_id'] . "</td>";
                                echo "<td>" . $row2['total_transactions'] . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="row mt-3">
            <div class="col-md-6">
                <h2>3. Average Balance by Province</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Province</th>
                            <th>Average Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Query to get average balance by province
                            $query3 = "SELECT a.province, AVG(u.balance) AS average_balance
                                       FROM address1 a
                                       INNER JOIN acc_detail ad ON a.address_id = ad.address_id
                                       INNER JOIN users u ON ad.detail_id = u.detail_id
                                       GROUP BY a.province";
                            $stmt3 = $conn->query($query3);
                            while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $row3['province'] . "</td>";
                                echo "<td>" . $row3['average_balance'] . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <h2>4. Difference Analysis by Transaction Type</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Transaction Type</th>
                            <th>Average Difference</th>
                            <th>Minimum Difference</th>
                            <th>Maximum Difference</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Query to get difference analysis by transaction type
                            $query4 = "SELECT r.transaction_type, AVG(h.difference) AS average_difference, MIN(h.difference) AS min_difference, MAX(h.difference) AS max_difference
                                       FROM reference r
                                       INNER JOIN history h ON r.ref_id = h.ref_id
                                       GROUP BY r.transaction_type";
                            $stmt4 = $conn->query($query4);
                            while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $row4['transaction_type'] . "</td>";
                                echo "<td>" . $row4['average_difference'] . "</td>";
                                echo "<td>" . $row4['min_difference'] . "</td>";
                                echo "<td>" . $row4['max_difference'] . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                 <div class="row mt-3">
                    <div class="col-md-6">
                        <h2>5. Vat Type Analysis</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Vat Type</th>
                            <th>Total Transactions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Query to get vat type analysis for transfers
                            $query5 = "SELECT v.vat_type, COUNT(*) AS total_transactions
                                       FROM reference r
                                       INNER JOIN history h ON r.ref_id = h.ref_id
                                       INNER JOIN vat v ON h.vat_type = v.vat_type
                                       WHERE r.transaction_type = 'transfer'
                                       GROUP BY v.vat_type";
                            $stmt5 = $conn->query($query5);
                            while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $row5['vat_type'] . "</td>";
                                echo "<td>" . $row5['total_transactions'] . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
                
            <!-- Add other analysis report tables here -->

        </div>
    </div>
</body>
</html>
