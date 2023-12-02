<?php
include '../function.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- End bootstrap cdn -->

</head>
<body>
    <?php include 'navbar.php'; ?>
    <main style="min-height: 100vh; margin-top: 10%; ">
        <div class="d-flex justify-content-center " >
        <h1>Đổi mật khẩu</h1>
        </div>
        <div class="d-flex justify-content-center ">
            <form class="w-25 " method="POST">
                <div class="mb-3 ">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col">
                        <input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">New Password</label>
                    <div class="col">
                        <input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password" name="newPassword" value="<?php echo isset($_POST['newPassword']) ? $_POST['newPassword'] : ''; ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class="col-form-label">Confirm New Password</label>
                    <div class="col">
                        <input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password" name="cfnewPassword" value="<?php echo isset($_POST['cfnewPassword']) ? $_POST['cfnewPassword'] : ''; ?>">
                    </div>
                </div>
                <input type="submit" class="mb-3 btn btn-primary" name="submitChange" value="Hoàn thành">
                <div class="mb-3">
                <?php
                if (isset($_POST['submitChange'])) {
                    if (empty($_POST['password'])) {
                        echo "<div class='alert alert-warning text-center' role='alert'>Vui lòng nhập mật khẩu</div>";
                    } else if (empty($_POST['newPassword'])) {
                        echo "<div class='alert alert-warning text-center' role='alert'>Vui lòng nhập mật khẩu mới</div>";
                    } else if (empty($_POST['cfnewPassword'])) {
                        echo "<div class='alert alert-warning text-center' role='alert'>Vui lòng nhập lại mật khẩu mới</div>";
                    } 
                    else if ($_POST['newPassword'] != $_POST['cfnewPassword']) {
                        echo "<div class='alert alert-warning text-center' role='alert'>Xác nhận mật khẩu không đúng</div>";
                    }
                     else {
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
                                echo "<div class='container-fluid alert alert-success text-center' role='alert'>Đổi mật khẩu thành công</div>";
                            }
                        }
                    }
                }
                ?>
                </div>
            </form>

        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>


</html>