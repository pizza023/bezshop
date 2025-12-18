<?php
include '../config/db.php';
$error = "";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $u = $_POST['username'];
    $p = $_POST['password'];

    $q = mysqli_query($conn,"SELECT * FROM users WHERE username='$u' AND role='admin'");
    $admin = mysqli_fetch_assoc($q);

    if($admin && password_verify($p,$admin['password'])){
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['role'] = 'admin';
        header("Location: index.php");
        exit;
    } else {
        $error = "เข้าสู่ระบบไม่สำเร็จ";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5" style="max-width:400px">
<h3 class="text-center mb-4">Admin Login</h3>

<?php if($error){ ?><div class="alert alert-danger"><?= $error ?></div><?php } ?>

<form method="post">
<input name="username" class="form-control mb-3" placeholder="Admin username">
<input type="password" name="password" class="form-control mb-3" placeholder="Password">
<button class="btn btn-dark w-100">Login</button>
</form>
</div>
</body>
</html>
