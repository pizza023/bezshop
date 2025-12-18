<?php
include '../config/db.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$q = mysqli_query($conn,"SELECT * FROM users WHERE username='$username' AND password='$password'");
$user = mysqli_fetch_assoc($q);

if($user){
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    header("location:../frontend/index.php");
}else{
    echo "ชื่อผู้ใช้หรือรหัสผ่านผิด";
}
