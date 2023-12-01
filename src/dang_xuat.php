<?php
session_start();
unset($_SESSION['login']);
header('Location: dang_nhap.php');
?>