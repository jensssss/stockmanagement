<?php
session_start();

// if(!isset($_SESSION["login"])){
//     header("Location: login.php");
//     exit;
// }
require 'function.php';

$stockTypes = getStockTypes();
$items = getItems();

if(isset($_POST["view_items"])){
    $items = getItemsByStockType($_POST["stock_type_id"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Stock Management</h1>
        <div class="mb-3">
            <a href="add_stock_type.php" class="btn btn-primary">Add Stock Type</a>
            <a href="add_item.php" class="btn btn-primary">Add Item</a>
            <a href="sell_item.php" class="btn btn-primary">Sell Item</a>
            <a href="logs.php" class="btn btn-primary">View Logs</a>
            <a href="sales_report.php" class="btn btn-primary">Sales Report</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <form action="" method="POST" class="mb-3">
            <div class="form-group">
                <label for="stock_type_id">View Items by Stock Type</label>
                <select name="stock_type_id" id="stock_type_id" class="form-control">
                    <?php foreach($stockTypes as $type): ?>
                        <option value="<?= $type["id"] ?>"><?= $type["type_name"] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="view_items" class="btn btn-primary mt-2">View Items</button>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Stock Type</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item): ?>
                <tr>
                    <td><?= $item["item_name"] ?></td>
                    <td><?= $item["type_name"] ?></td>
                    <td><?= $item["price"] ?></td>
                    <td><?= $item["quantity"] ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
