<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/dang_ki.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>
    <?php
        include '../function.php'; 
        include 'navbar.php'; 
    ?>
    <main>
        <form class="pass-form" method="POST">
            <h2 class="title">Đổi mật khẩu</h2>
            <div class="form-input">
                <label for="inputPassword" class="">Mật khẩu cũ</label>
                <input type="password" class="" id="inputPassword" placeholder="Nhập mật khẩu cũ" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
            </div>
            <div class="form-input">
                <label for="inputPassword" class="">Mật khẩu mới</label>
                <input type="password" class="" id="inputPassword" placeholder="Nhập mật khẩu mới" name="newPassword" value="<?php echo isset($_POST['newPassword']) ? $_POST['newPassword'] : ''; ?>">

            </div>
            <div class="form-input">
                <label for="inputPassword" class="">Nhập lại mật khẩu</label>
                <input type="password" class="" id="inputPassword" placeholder="Nhập lại mật khẩu" name="cfnewPassword" value="<?php echo isset($_POST['cfnewPassword']) ? $_POST['cfnewPassword'] : ''; ?>">
            </div>
            <input type="submit" class="btn-submit" name="submitChange" value="Hoàn thành">
            <div class="">
                <?php
                if (isset($_POST['submitChange'])) {
                    if (empty($_POST['password'])) {
                        echo "<div class='alert alert-warning text-center' role='alert'>Vui lòng nhập mật khẩu</div>";
                    } else if (empty($_POST['newPassword'])) {
                        echo "<div class='alert alert-warning text-center' role='alert'>Vui lòng nhập mật khẩu mới</div>";
                    } else if (empty($_POST['cfnewPassword'])) {
                        echo "<div class='alert alert-warning text-center' role='alert'>Vui lòng nhập lại mật khẩu mới</div>";
                    } else if ($_POST['newPassword'] != $_POST['cfnewPassword']) {
                        echo "<div class='alert alert-warning text-center' role='alert'>Xác nhận mật khẩu không đúng</div>";
                    } else {
                        $password = $_POST['password'];
                        $password = md5($password);
                        $newPassword = $_POST['newPassword'];
                        $newPassword = md5($newPassword);
                        $sql_check = "SELECT * FROM user WHERE id_user = '{$_SESSION['login']['id']}'";
                        $result_check = mysqli_query($conn, $sql_check);
                        $row = mysqli_fetch_assoc($result_check);
                        if ($row['password'] != $password) {
                            echo "<div class='alert alert-warning text-center' role='alert'>Sai mật khẩu</div>";
                        } else {
                            $sql = "UPDATE user SET password = '{$newPassword}' WHERE id_user = '{$_SESSION['login']['id']}'";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                header('Location: ./src/dang_nhap.php');
                            }
                        }
                    }
                }
                ?>
            </div>
        </form>
    </main>
    
</body>

</html>