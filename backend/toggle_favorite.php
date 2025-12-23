<?php
session_start();
include '../config/db.php';
$uid=$_SESSION['user_id']??0;
$pid=(int)$_GET['id'];
if(!$uid) exit;

$c=mysqli_query($conn,"SELECT id FROM favorites WHERE user_id=$uid AND product_id=$pid");
if(mysqli_num_rows($c)){
mysqli_query($conn,"DELETE FROM favorites WHERE user_id=$uid AND product_id=$pid");
}else{
mysqli_query($conn,"INSERT INTO favorites(user_id,product_id) VALUES($uid,$pid)");
}
header("Location: ../frontend/index.php");
