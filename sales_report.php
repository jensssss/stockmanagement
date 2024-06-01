<?php
session_start();

// if(!isset($_SESSION["login"])){
//     header("Location: login.php");
//     exit;
// }
require 'function.php';

$sales = getSalesReport();
$total_omzet = getTotalOmzet();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Sales Report</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity Sold</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Sale Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($sales as $sale): ?>
                <tr>
                    <td><?= $sale["item_name"] ?></td>
                    <td><?= $sale["quantity_sold"] ?></td>
                    <td><?= $sale["price"] ?></td>
                    <td><?= $sale["quantity_sold"] * $sale["price"] ?></td>
                    <td><?= $sale["sale_date"] ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <h3>Total Omzet: <?= $total_omzet ?></h3>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
