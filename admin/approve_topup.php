<?php
include 'check_admin.php';

$id = $_GET['id'];

// ดึงข้อมูลคำขอเติมเงิน
$q = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM topup_requests WHERE id=$id")
);

$uid = $q['user_id'];
$amount = $q['amount'];

// เพิ่มเงินให้ user
mysqli_query($conn,"
    UPDATE users 
    SET balance = balance + $amount 
    WHERE id = $uid
");

// เปลี่ยนสถานะคำขอ
mysqli_query($conn,"
    UPDATE topup_requests 
    SET status='approved' 
    WHERE id=$id
");

// บันทึกประวัติ wallet
mysqli_query($conn,"
    INSERT INTO wallet_logs (user_id, amount, type)
    VALUES ($uid, $amount, 'topup')
");

header("Location: topup.php");
exit;
