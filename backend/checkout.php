<?php
include '../config/db.php';

$user_id = $_SESSION['user_id'];
$address = $_POST['address'];
$payment = $_POST['payment_method'];

// ดึงของในตะกร้า
$cart = mysqli_query($conn,"
    SELECT c.*, p.price 
    FROM cart c 
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = $user_id
");

$total = 0;
while($c = mysqli_fetch_assoc($cart)){
    $total += $c['price'] * $c['quantity'];
}

// สร้าง order
mysqli_query($conn,"
    INSERT INTO orders (user_id,address,payment_method,total_price)
    VALUES ($user_id,'$address','$payment',$total)
");

$order_id = mysqli_insert_id($conn);

// บันทึก order_items
mysqli_data_seek($cart, 0);
while($c = mysqli_fetch_assoc($cart)){
    mysqli_query($conn,"
        INSERT INTO order_items (order_id,product_id,quantity,price)
        VALUES (
            $order_id,
            {$c['product_id']},
            {$c['quantity']},
            {$c['price']}
        )
    ");
}

// ล้างตะกร้า
mysqli_query($conn,"DELETE FROM cart WHERE user_id=$user_id");

header("Location: ../frontend/orders.php");
