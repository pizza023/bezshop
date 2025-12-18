<?php
include 'check_admin.php';

$result = mysqli_query($conn,"
    SELECT t.*, u.username 
    FROM topup_requests t
    JOIN users u ON t.user_id = u.id
    ORDER BY t.id DESC
");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>อนุมัติเติมเงิน</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<h3>💰 อนุมัติการเติมเงิน</h3>

<table class="table table-bordered mt-3 bg-white">
<thead class="table-dark">
<tr>
    <th>#</th>
    <th>ผู้ใช้</th>
    <th>จำนวนเงิน</th>
    <th>สถานะ</th>
    <th>จัดการ</th>
</tr>
</thead>

<tbody>
<?php while($t = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?= $t['id'] ?></td>
    <td><?= $t['username'] ?></td>
    <td><?= number_format($t['amount']) ?> บาท</td>
    <td><?= $t['status'] ?></td>
    <td>
        <?php if($t['status']=='pending'){ ?>
            <a href="approve_topup.php?id=<?= $t['id'] ?>"
               class="btn btn-success btn-sm">
               อนุมัติ
            </a>
        <?php } else { ?>
            <span class="text-success">✔ สำเร็จ</span>
        <?php } ?>
    </td>
</tr>
<?php } ?>
</tbody>
</table>

<a href="index.php" class="btn btn-outline-dark">⬅ กลับ Dashboard</a>
</div>

</body>
</html>
