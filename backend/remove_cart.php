<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../frontend/login.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM cart WHERE id=$id");

header("Location: ../frontend/cart.php");
exit;
