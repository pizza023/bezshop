<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){ header("Location: ../frontend/login.php"); exit; }

$uid=$_SESSION['user_id'];
$pid=(int)$_GET['id'];

$p=mysqli_fetch_assoc(mysqli_query($conn,"SELECT stock FROM products WHERE id=$pid"));
if($p['stock']<=0){ die('สินค้าหมด'); }

$c=mysqli_query($conn,"SELECT id,qty FROM cart WHERE user_id=$uid AND product_id=$pid");
if(mysqli_num_rows($c)){
    mysqli_query($conn,"UPDATE cart SET qty=qty+1 WHERE user_id=$uid AND product_id=$pid");
}else{
    mysqli_query($conn,"INSERT INTO cart(user_id,product_id,qty) VALUES($uid,$pid,1)");
}

header("Location: ../frontend/cart.php");
