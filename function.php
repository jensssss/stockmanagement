<?php
$conn = mysqli_connect("localhost", "root", "", "stock_management");

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function addStockType($data){
    global $conn;
    $type_name = htmlspecialchars($data["type_name"]);
    $query = "INSERT INTO stock_types (type_name) VALUES ('$type_name')";
    mysqli_query($conn, $query);
    logAction($_SESSION["user_id"], "Added stock type: $type_name");
    return mysqli_affected_rows($conn);
}

function addItem($data){
    global $conn;
    $item_name = htmlspecialchars($data["item_name"]);
    $stock_type_id = htmlspecialchars($data["stock_type_id"]);
    $price = htmlspecialchars($data["price"]);
    $quantity = htmlspecialchars($data["quantity"]);
    $query = "INSERT INTO items (item_name, stock_type_id, price, quantity) VALUES ('$item_name', '$stock_type_id', '$price', '$quantity')";
    mysqli_query($conn, $query);
    logAction($_SESSION["user_id"], "Added item: $item_name");
    return mysqli_affected_rows($conn);
}

function sellItem($data){
    global $conn;
    $item_id = htmlspecialchars($data["item_id"]);
    $quantity_sold = htmlspecialchars($data["quantity_sold"]);
    
    $query = "INSERT INTO sales (item_id, quantity_sold, sale_date, user_id) VALUES ('$item_id', '$quantity_sold', NOW(), '".$_SESSION["user_id"]."')";
    mysqli_query($conn, $query);
    
    $query = "UPDATE items SET quantity = quantity - $quantity_sold WHERE id = '$item_id'";
    mysqli_query($conn, $query);
    logAction($_SESSION["user_id"], "Sold item ID: $item_id, Quantity: $quantity_sold");
    return mysqli_affected_rows($conn);
}

function getSalesReport(){
    global $conn;
    $query = "SELECT sales.*, items.item_name, items.price FROM sales LEFT JOIN items ON sales.item_id = items.id";
    return query($query);
}

function getTotalOmzet(){
    global $conn;
    $query = "SELECT SUM(sales.quantity_sold * items.price) as total_omzet FROM sales LEFT JOIN items ON sales.item_id = items.id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['total_omzet'];
}

function getStockTypes(){
    return query("SELECT * FROM stock_types");
}

function getItemsByStockType($stock_type_id){
    return query("SELECT items.*, stock_types.type_name FROM items LEFT JOIN stock_types ON items.stock_type_id = stock_types.id WHERE stock_type_id = $stock_type_id");
}

function getItems(){
    return query("SELECT items.*, stock_types.type_name FROM items LEFT JOIN stock_types ON items.stock_type_id = stock_types.id");
}

function register($data){
    global $conn;
    $username = strtolower(stripcslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    $result = query("SELECT username FROM users WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        echo "<script> alert('Username already registered!') </script>";
        return false;
    }

    if($password !== $password2){
        echo "<script> alert('Password does not match!') </script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    mysqli_query($conn, $query);
    logAction(mysqli_insert_id($conn), "Registered new user: $username");
    return mysqli_affected_rows($conn);
}

function login($data){
    global $conn;
    $username = $data["username"];
    $password = $data["password"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"])){
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];

            if(isset($_POST["remember"])){
                setcookie("id", $row["id"], time() + 60);
                setcookie("key", hash("sha256", $row["username"]), time() + 60);
            }
            logAction($row["id"], "Logged in");
            header("Location: index.php");
            exit;
        } else {
            echo "<script> alert('Incorrect password!') </script>";
            return false;
        }
    } else {
        echo "<script> alert('Username not registered!') </script>";
        return false;
    }
}

function logAction($user_id, $action){
    global $conn;
    $query = "INSERT INTO logs (user_id, action, log_date) VALUES ('$user_id', '$action', NOW())";
    mysqli_query($conn, $query);
}

function getLogs(){
    global $conn;
    $query = "SELECT logs.*, users.username FROM logs LEFT JOIN users ON logs.user_id = users.id ORDER BY log_date DESC";
    return query($query);
}
?>
