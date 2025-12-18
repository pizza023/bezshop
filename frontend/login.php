<?php
include '../config/db.php';

$error = "";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn,"
        SELECT * FROM users WHERE username='$username'
    ");

    $user = mysqli_fetch_assoc($result);

    if($user && password_verify($password,$user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        header("Location: index.php");
        exit;
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>เข้าสู่ระบบ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5" style="max-width:400px">
<h3 class="mb-4 text-center">เข้าสู่ระบบ</h3>

<?php if($error){ ?>
<div class="alert alert-danger"><?= $error; ?></div>
<?php } ?>

<form method="post">
<input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
<button class="btn btn-dark w-100">Login</button>
</form>

<a href="register.php" class="d-block text-center mt-3">สมัครสมาชิก</a>
</div>
</body>
</html>
