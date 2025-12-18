<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../frontend/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'];

// เช็คว่ามีแล้วหรือยัง
$check = mysqli_query($conn,"
    SELECT * FROM favorites 
    WHERE user_id=$user_id AND product_id=$product_id
");

if(mysqli_num_rows($check)==0){
    mysqli_query($conn,"
        INSERT INTO favorites (user_id,product_id)
        VALUES ($user_id,$product_id)
    ");
}

header("Location: ../frontend/favorites.php");
