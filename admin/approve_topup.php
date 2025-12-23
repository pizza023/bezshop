<?php
include 'check_admin.php';

$id = (int)$_GET['id'];

$topup = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM topup_requests WHERE id=$id AND status='pending'")
);

if(!$topup){
    die("ไม่พบคำขอ");
}

/* เพิ่มเงิน */
mysqli_query($conn,"
    UPDATE users
    SET balance = balance + {$topup['amount']}
    WHERE id = {$topup['user_id']}
");

/* log */
mysqli_query($conn,"
    INSERT INTO wallet_logs(user_id,amount,type)
    VALUES({$topup['user_id']},{$topup['amount']},'topup')
");

/* update status */
mysqli_query($conn,"
    UPDATE topup_requests
    SET status='approved'
    WHERE id=$id
");

header("Location: topup.php");
exit;
