<?php
include 'check_admin.php';

$id = (int)$_GET['id'];

$order = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM orders WHERE id=$id")
);
if(!$order){ die('ไม่พบออเดอร์'); }

$user = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM users WHERE id={$order['user_id']}")
);

/* ตรวจ stock */
$items = mysqli_query($conn,"
    SELECT oi.*, p.stock
    FROM order_items oi
    JOIN products p ON p.id = oi.product_id
    WHERE oi.order_id=$id
");

while($i=mysqli_fetch_assoc($items)){
    if($i['stock'] < $i['qty']){
        die("❌ สต็อกสินค้าไม่พอ");
    }
}

/* ตัดเงิน wallet */
if($order['payment_method']=='wallet'){
    if($user['balance'] < $order['total_price']){
        die("❌ เงินใน Wallet ไม่พอ");
    }

    mysqli_query($conn,"
        UPDATE users
        SET balance = balance - {$order['total_price']}
        WHERE id = {$user['id']}
    ");

    mysqli_query($conn,"
        INSERT INTO wallet_logs(user_id,amount,type)
        VALUES({$user['id']},-{$order['total_price']},'order')
    ");
}

/* ตัด stock */
mysqli_data_seek($items,0);
while($i=mysqli_fetch_assoc($items)){
    mysqli_query($conn,"
        UPDATE products
        SET stock = stock - {$i['qty']}
        WHERE id = {$i['product_id']}
    ");
}

/* อนุมัติ */
mysqli_query($conn,"UPDATE orders SET status='approved' WHERE id=$id");

header("Location: orders.php");
exit;
