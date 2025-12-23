<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../frontend/login.php");
    exit;
}

$uid = $_SESSION['user_id'];
$pid = (int)$_GET['id'];

$check = mysqli_query($conn,"
    SELECT id FROM favorites
    WHERE user_id=$uid AND product_id=$pid
");

if(mysqli_num_rows($check)>0){
    mysqli_query($conn,"
        DELETE FROM favorites
        WHERE user_id=$uid AND product_id=$pid
    ");
}else{
    mysqli_query($conn,"
        INSERT INTO favorites(user_id,product_id)
        VALUES($uid,$pid)
    ");
}

header("Location: ../frontend/index.php");
exit;
