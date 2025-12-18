<?php
include '../config/db.php';

$id = intval($_GET['id']);

$req = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM topup_requests WHERE id=$id")
);

if($req){
    $uid = $req['user_id'];
    $amount = $req['amount'];

    // เพิ่มเงิน
    mysqli_query($conn,"
        UPDATE users SET balance = balance + $amount WHERE id=$uid
    ");

    // บันทึก log
    mysqli_query($conn,"
        INSERT INTO wallet_logs(user_id,amount,type,note)
        VALUES($uid,$amount,'topup','แอดมินอนุมัติการเติมเงิน')
    ");

    // อัปเดตสถานะ
    mysqli_query($conn,"
        UPDATE topup_requests SET status='approved' WHERE id=$id
    ");
}

header("Location: ../admin/topup.php");
exit;
