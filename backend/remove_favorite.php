<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../frontend/login.php");
    exit;
}

$id = (int)$_GET['id'];
$uid = $_SESSION['user_id'];

mysqli_query($conn,"
    DELETE FROM favorites
    WHERE id=$id AND user_id=$uid
");

header("Location: ../frontend/favorites.php");
