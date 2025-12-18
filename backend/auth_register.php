<?php
include '../config/db.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = "INSERT INTO users (username,password) VALUES ('$username','$password')";
mysqli_query($conn,$sql);

header("location:../frontend/login.php");
