<?php
include '../config/db.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn,"
        INSERT INTO users(username,password)
        VALUES('$username','$password')
    ");

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>สมัครสมาชิก</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5" style="max-width:400px">
<h3 class="mb-4 text-center">สมัครสมาชิก</h3>

<form method="post">
<input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
<button class="btn btn-dark w-100">สมัครสมาชิก</button>
</form>

<a href="login.php" class="d-block text-center mt-3">มีบัญชีแล้ว? เข้าสู่ระบบ</a>
</div>
</body>
</html>
