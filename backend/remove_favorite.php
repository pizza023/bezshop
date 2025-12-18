<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../frontend/login.php");
    exit;
}

$id = $_GET['id'];

// ลบรายการโปรด
mysqli_query($conn,"DELETE FROM favorites WHERE id=$id");

// 🔁 กลับไปหน้า favorites ที่ถูกต้อง
header("Location: ../frontend/favorites.php");
exit;
