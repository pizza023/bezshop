<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "bezshop";

$conn = mysqli_connect($host,$user,$pass,$db);
if(!$conn){
    die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ");
}