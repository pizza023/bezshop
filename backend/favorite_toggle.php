<?php
session_start();
include '../config/db.php';

$uid = $_SESSION['user_id'] ?? 0;
$id = $_GET['id'];

$chk = mysqli_query($conn,"
SELECT * FROM favorites 
WHERE user_id='$uid' AND product_id='$id'
");

if(mysqli_num_rows($chk)){
    mysqli_query($conn,"
    DELETE FROM favorites 
    WHERE user_id='$uid' AND product_id='$id'
    ");
}else{
    mysqli_query($conn,"
    INSERT INTO favorites(user_id,product_id)
    VALUES('$uid','$id')
    ");
}
