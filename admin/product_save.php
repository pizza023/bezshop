<?php
include 'check_admin.php';

$name  = $_POST['name'];
$price = $_POST['price'];

$image = $_FILES['image']['name'];
$tmp   = $_FILES['image']['tmp_name'];

move_uploaded_file($tmp, "../assets/img/".$image);

mysqli_query($conn,"
    INSERT INTO products (name, price, image)
    VALUES ('$name','$price','$image')
");

header("Location: products.php");
exit;
