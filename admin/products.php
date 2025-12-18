<?php
include 'check_admin.php';

$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการสินค้า</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<h3>👟 จัดการสินค้า</h3>

<!-- ฟอร์มเพิ่มสินค้า -->
<div class="card mb-4">
<div class="card-body">
<h5>➕ เพิ่มสินค้าใหม่</h5>

<form action="product_save.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" placeholder="ชื่อสินค้า" required>
        </div>
        <div class="col-md-3">
            <input type="number" name="price" class="form-control" placeholder="ราคา" required>
        </div>
        <div class="col-md-3">
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="col-md-2">
            <button class="btn btn-dark w-100">บันทึก</button>
        </div>
    </div>
</form>
</div>
</div>

<!-- ตารางสินค้า -->
<table class="table table-bordered bg-white">
<thead class="table-dark">
<tr>
    <th>#</th>
    <th>รูป</th>
    <th>ชื่อ</th>
    <th>ราคา</th>
    <th>จัดการ</th>
</tr>
</thead>

<tbody>
<?php while($p = mysqli_fetch_assoc($products)){ ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td>
        <img src="../assets/img/<?= $p['image'] ?>" width="60">
    </td>
    <td><?= $p['name'] ?></td>
    <td><?= number_format($p['price']) ?> บาท</td>
    <td>
        <a href="product_delete.php?id=<?= $p['id'] ?>"
           onclick="return confirm('ลบสินค้านี้?')"
           class="btn btn-danger btn-sm">
           ลบ
        </a>
    </td>
</tr>
<?php } ?>
</tbody>
</table>

<a href="index.php" class="btn btn-outline-dark mt-3">⬅ กลับหน้าแอดมิน</a>
</div>

</body>
</html>
