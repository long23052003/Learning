<?php
include '../function.php';
if (isset($_POST['submitLogin'])) {
    if (empty($_POST['username'])) {
        echo '<div class="alert-warning" role="alert">Vui lòng nhập tên đăng nhập!</div>';
    } else if (empty($_POST['password'])) {
        echo '<div class="alert-warning" role="alert">Vui lòng nhập mật khẩu!</div>';
    } else {
        if (checkLogin($_POST['username'], $_POST['password'])) {
            header('Location: khoa_hoc.php');
        } else {
            echo '<div class="alert-warning" role="alert">Tên đăng nhập hoặc mật khẩu không đúng!</div>';
        }
    }
}
 if(isLogin()){
     header('Location: khoa_hoc.php');
 }
?>