<?php
include 'function.php';

if(isset($_POST['submitLogin'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(checkLogin($username, $password)){
        header('Location: khoa_hoc.php');
    } else {
        echo '<div class="alert alert-danger text-center" role="alert">Tài khoản hoặc mật khẩu không chính xác</div>';
    }
}

if(isLogin()){
    header('Location: khoa_hoc.php');
}

?>