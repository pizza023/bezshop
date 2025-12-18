<?php
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['user_id'];
$result = mysqli_query($conn,"
    SELECT * FROM wallet_logs 
    WHERE user_id=$uid 
    ORDER BY created_at DESC
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
<h3>📒 ประวัติการเงิน</h3>

<table class="table mt-3">
<tr>
<th>วันเวลา</th>
<th>จำนวน</th>
<th>ประเภท</th>
<th>หมายเหตุ</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?= $row['created_at']; ?></td>
<td><?= number_format($row['amount']); ?></td>
<td><?= $row['type']; ?></td>
<td><?= $row['note']; ?></td>
</tr>
<?php } ?>

</table>

<a href="index.php" class="btn btn-dark">กลับหน้าแรก</a>
</div>
</body>
</html>
