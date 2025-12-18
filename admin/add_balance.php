<?php
include '../config/db.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $uid = intval($_POST['user_id']);
    $amount = intval($_POST['amount']);

    mysqli_query($conn,"
        UPDATE users SET balance = balance + $amount WHERE id=$uid
    ");

    mysqli_query($conn,"
        INSERT INTO wallet_logs(user_id,amount,type,note)
        VALUES($uid,$amount,'admin_add','แอดมินเพิ่มเงิน')
    ");
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Admin เติมเงิน</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
<h3>💼 แอดมินเพิ่มเงิน</h3>

<form method="post">
<input type="number" name="user_id" class="form-control mb-2" placeholder="User ID">
<input type="number" name="amount" class="form-control mb-2" placeholder="จำนวนเงิน">
<button class="btn btn-success w-100">เพิ่มเงิน</button>
</form>

</div>
</body>
</html>
