<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../frontend/login.php");
    exit;
}

$uid = $_SESSION['user_id'];
$payment = $_POST['payment_method'] ?? 'wallet';

/* ดึงของในตะกร้า */
$cart = mysqli_query($conn,"
    SELECT c.*, p.price
    FROM cart c
    JOIN products p ON p.id=c.product_id
    WHERE c.user_id=$uid
");

if(mysqli_num_rows($cart)==0){
    die("ไม่มีสินค้าในตะกร้า");
}

$total = 0;
while($c=mysqli_fetch_assoc($cart)){
    $total += $c['qty'] * $c['price'];
}

/* สร้าง order */
mysqli_query($conn,"
    INSERT INTO orders(user_id,payment_method,total_price)
    VALUES($uid,'$payment',$total)
");
$order_id = mysqli_insert_id($conn);

/* เพิ่ม order_items */
mysqli_data_seek($cart,0);
while($c=mysqli_fetch_assoc($cart)){
    mysqli_query($conn,"
        INSERT INTO order_items(order_id,product_id,qty,price)
        VALUES($order_id,{$c['product_id']},{$c['qty']},{$c['price']})
    ");
}

/* ล้างตะกร้า */
mysqli_query($conn,"DELETE FROM cart WHERE user_id=$uid");

header("Location: ../frontend/orders.php");
exit;
