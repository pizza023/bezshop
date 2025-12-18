<?php
include 'check_admin.php';

$id = $_GET['id'] ?? 0;
$status = $_GET['status'] ?? '';

$allow = ['approved','shipped'];

if(!$id || !in_array($status,$allow)){
    die("ข้อมูลไม่ถูกต้อง");
}

mysqli_query($conn,"
    UPDATE orders 
    SET status='$status'
    WHERE id=$id
");

header("Location: orders.php");
exit;
