
<?php
include '../config/db.php';
if(!isset($_SESSION['role']) || $_SESSION['role']!='admin'){ die('Access denied'); }
?>
