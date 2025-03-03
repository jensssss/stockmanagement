<?php
session_start();

// if(!isset($_SESSION["login"])){
//     header("Location: login.php");
//     exit;
// }
require 'function.php';

$items = getItems();

if(isset($_POST["submit"])){
    if(sellItem($_POST) > 0){
        echo "<script>alert('Item sold successfully!'); document.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Failed to sell item!'); document.location.href = 'index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Item</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Sell Item</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="item_id">Item</label>
                <select name="item_id" id="item_id" class="form-control" required>
                    <?php foreach($items as $item): ?>
                        <option value="<?= $item["id"] ?>"><?= $item["item_name"] ?> (<?= $item["quantity"] ?> in stock)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity_sold">Quantity</label>
                <input type="number" name="quantity_sold" id="quantity_sold" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Sell Item</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
