<?php
session_start();

// if(!isset($_SESSION["login"])){
//     header("Location: login.php");
//     exit;
// }
require 'function.php';

if(isset($_POST["submit"])){
    if(addStockType($_POST) > 0){
        echo "<script>alert('Stock type added successfully!'); document.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Failed to add stock type!'); document.location.href = 'index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stock Type</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Add Stock Type</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="type_name">Stock Type Name</label>
                <input type="text" name="type_name" id="type_name" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add Stock Type</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
