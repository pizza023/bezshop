<?php
include '../config/db.php';

$id = intval($_GET['id']);

mysqli_query($conn,"
    UPDATE orders SET status='approved' WHERE id=$id
");

header("Location: ../admin/orders.php");
exit;
