<?php
// ใช้คู่กับ guard.php
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Admin Panel</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.admin-navbar{
    background:#000;
}
.admin-navbar .nav-link,
.admin-navbar .navbar-brand{
    color:#fff !important;
}
.admin-navbar .nav-link:hover{
    color:#ccc !important;
}
</style>
</head>

<body>

<nav class="navbar admin-navbar px-4">
    <span class="navbar-brand fw-bold">🛠 ADMIN PANEL</span>

    <div>
        <a href="index.php" class="nav-link d-inline me-3">Dashboard</a>
        <a href="products.php" class="nav-link d-inline me-3">Products</a>
        <a href="topup.php" class="nav-link d-inline me-3">Topup</a>
        <a href="../backend/logout.php" class="nav-link d-inline text-danger">Logout</a>
    </div>
</nav>

<div class="container mt-4">
