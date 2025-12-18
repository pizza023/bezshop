<?php
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['user_id'];

$logs = mysqli_query($conn,"
    SELECT * FROM wallet_logs 
    WHERE user_id=$uid 
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ประวัติ Wallet</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
<h3>💳 ประวัติการเงิน (Wallet)</h3>

<table class="table table-bordered mt-3">
<thead class="table-dark">
<tr>
    <th>#</th>
    <th>ประเภท</th>
    <th>จำนวนเงิน</th>
    <th>วันที่</th>
</tr>
</thead>

<tbody>
<?php while($w=mysqli_fetch_assoc($logs)){ ?>
<tr>
    <td><?= $w['id'] ?></td>
    <td>
        <?php
        if($w['type']=='topup') echo '➕ เติมเงิน';
        if($w['type']=='order') echo '🛒 ชำระสินค้า';
        ?>
    </td>
    <td><?= number_format($w['amount']) ?> บาท</td>
    <td><?= date('d/m/Y H:i', strtotime($w['created_at'])) ?></td>
</tr>
<?php } ?>
</tbody>
</table>

<a href="wallet.php" class="btn btn-dark">⬅ กลับ Wallet</a>
</div>
</body>
</html>
