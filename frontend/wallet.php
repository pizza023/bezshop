<?php
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Wallet</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <h3>💰 เติมเงิน (รอแอดมินอนุมัติ)</h3>

    <form action="../backend/request_topup.php" method="post" class="mt-4">
        <input type="number" name="amount" class="form-control mb-3" placeholder="จำนวนเงิน" required>
        <button class="btn btn-dark w-100">ส่งคำขอเติมเงิน</button>
    </form>
    <a href="wallet_history.php" class="btn btn-outline-dark mt-2">
📄 ดูประวัติการเงิน
</a>
    <a href="index.php" class="btn btn-secondary w-100 mt-3">กลับหน้าแรก</a>
</div>

</body>
</html>
