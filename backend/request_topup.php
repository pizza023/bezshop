<?php
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../frontend/login.php");
    exit;
}

$uid = $_SESSION['user_id'];
$amount = intval($_POST['amount']);

if($amount > 0){
    mysqli_query($conn,"
        INSERT INTO topup_requests(user_id,amount)
        VALUES($uid,$amount)
    ");
}

// ⬅️ ส่งกลับหน้า index ทันที
header("Location: ../frontend/index.php");
exit;
