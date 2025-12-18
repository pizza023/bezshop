<?php
include '../config/db.php';
$user_id = $_SESSION['user_id'];
$address = $_POST['address'];
$payment = $_POST['payment'];
$total = $_POST['total'];

$user = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT balance FROM users WHERE id=$user_id")
);

if($payment=="WALLET" && $user['balance'] < $total){
    die("เงินใน Wallet ไม่พอ");
}

mysqli_query($conn,"
INSERT INTO orders (user_id,address,payment_method,total)
VALUES ($user_id,'$address','$payment',$total)
");

$order_id = mysqli_insert_id($conn);

$q = mysqli_query($conn,"SELECT * FROM cart WHERE user_id=$user_id");
while($c=mysqli_fetch_assoc($q)){
    mysqli_query($conn,"
    INSERT INTO order_items (order_id,product_id,qty,price)
    VALUES ($order_id,{$c['product_id']},{$c['qty']},$total)
    ");
}

mysqli_query($conn,"DELETE FROM cart WHERE user_id=$user_id");

if($payment=="WALLET"){
    mysqli_query($conn,"
    UPDATE users SET balance = balance - $total WHERE id=$user_id
    ");
    mysqli_query($conn,"
    INSERT INTO wallet_logs (user_id,amount,type)
    VALUES ($user_id,-$total,'ชำระสินค้า')
    ");
}

header("location:../frontend/orders.php");
// ตัดเงิน wallet
mysqli_query($conn,"
    UPDATE users SET balance = balance - $total WHERE id=$uid
");

// log การใช้เงิน
mysqli_query($conn,"
    INSERT INTO wallet_logs(user_id,amount,type,note)
    VALUES($uid,-$total,'purchase','สั่งซื้อสินค้า')
");

mysqli_query($conn,"
INSERT INTO orders(user_id,total_price,status,address,payment_method)
VALUES($uid,$total,'pending','$address','$payment')
");
