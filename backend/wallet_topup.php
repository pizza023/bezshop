<?php
include '../config/db.php';

$user_id = $_SESSION['user_id'];
$amount = $_POST['amount'];

mysqli_query($conn,"
UPDATE users SET balance = balance + $amount WHERE id=$user_id
");

mysqli_query($conn,"
INSERT INTO wallet_logs (user_id,amount,type)
VALUES ($user_id,$amount,'เติมเงิน')
");

header("location:../frontend/wallet.php");
