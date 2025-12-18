<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../frontend/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$address = mysqli_real_escape_string($conn, $_POST['address']);
$payment = $_POST['payment_method'];

// ดึงตะกร้า
$cart = mysqli_query($conn,"
    SELECT c.*, p.price 
    FROM cart c 
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = $user_id
");

$total = 0;
while($c = mysqli_fetch_assoc($cart)){
    $total += $c['price'] * $c['qty'];
}

// ถ้าไม่มีสินค้า
if($total <= 0){
    die("ไม่มีสินค้าในตะกร้า");
}

// สร้าง order (สถานะ = pending)
mysqli_query($conn,"
    INSERT INTO orders (user_id,address,payment_method,total_price,status)
    VALUES ($user_id,'$address','$payment',$total,'pending')
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
            {$c['qty']},
            {$c['price']}
        )
    ");
}

// ล้างตะกร้า
mysqli_query($conn,"DELETE FROM cart WHERE user_id=$user_id");

// ✅ กลับหน้า “คำสั่งซื้อของฉัน”
header("Location: ../frontend/orders.php");
exit;
