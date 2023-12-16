<?php
session_start();
include 'connectdb.php';

// Begin Login function
function isLogin()
{
    // hàm kiểm tra đã đăng nhập chưa
    if (isset($_SESSION['login']) && $_SESSION['login']['isLogin'] == true) {
        return true;
    } else {
        return false;
    }
}

// begin checkLogin
function checkLogin($username, $password)
{
    // hàm kiểm tra tài khoản nhập đã đúng chưa
    global $conn;
    $password = md5($password);
    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) == 0) {
        return false;
    } else {
        $row = mysqli_fetch_assoc($query);
        if ($row) {
            $_SESSION['login'] = ['username' => $username, 'id' => $row['id_user'], 'isLogin' => true,'role'=>$row['role'], 'img_avt'=>$row['img_avt'] ,'lan_thi'=>0];
            return true;
        } else {
            return false;
        }
    }
}

// end checkLogin
