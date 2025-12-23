<?php
include 'check_admin.php';

/* ดึงคำขอเติมเงิน */
$result = mysqli_query($conn,"
    SELECT t.*, u.username
    FROM topup_requests t
    JOIN users u ON u.id = t.user_id
    WHERE t.status='pending'
    ORDER BY t.id DESC
");

if(!$result){
    die("SQL ERROR : ".mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>อนุมัติการเติมเงิน</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">

<a href="index.php" class="btn btn-outline-secondary mb-3">← กลับ Dashboard</a>

<h3>💰 คำขอเติมเงิน</h3>

<table class="table table-bordered mt-3 align-middle">
<thead class="table-dark">
<tr>
    <th>#</th>
    <th>ผู้ใช้</th>
    <th>จำนวนเงิน</th>
    <th>วันที่</th>
    <th>จัดการ</th>
</tr>
</thead>
<tbody>

<?php if(mysqli_num_rows($result)==0){ ?>
<tr>
<td colspan="5" class="text-center text-muted">
    ไม่มีคำขอเติมเงิน
</td>
</tr>
<?php } ?>

<?php while($t=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?= $t['id'] ?></td>
<td><?= htmlspecialchars($t['username']) ?></td>
<td><?= number_format($t['amount'],2) ?> บาท</td>
<td><?= date('d/m/Y H:i',strtotime($t['created_at'])) ?></td>
<td>
    <a href="approve_topup.php?id=<?= $t['id'] ?>"
       class="btn btn-success btn-sm w-100">
       ✔ อนุมัติ
    </a>
</td>
</tr>
<?php } ?>

</tbody>
</table>

</div>
</body>
</html>
