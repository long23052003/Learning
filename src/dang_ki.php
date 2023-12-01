<?php include '../function.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng kí</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- End bootstrap cdn -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <main style="min-height: 100vh; margin-top: 10%;">
        <div class="d-flex justify-content-center">
            <h1>Đăng kí</h1>
        </div>
        <div class="d-flex justify-content-center">
            <form class="w-25" method="POST">
                <?php
                if (isset($_POST['submitRegister'])) {
                    unset($_SESSION['login']);
                    if (empty($_POST['username'])) {
                        echo '<div class="alert alert-warning text-center" role="alert">Vui lòng nhập tài khoản</div>';
                    } else if (empty($_POST['password'])) {
                        echo '<div class="alert alert-warning text-center" role="alert">Vui lòng nhập mật khẩu</div>';
                    } else if (empty($_POST['password2'])) {
                        echo '<div class="alert alert-warning text-center" role="alert">Vui lòng nhập lại mật khẩu</div>';
                    } else {
                        if ($_POST['password'] === $_POST['password2']) {
                            $username = $_POST['username'];
                            $password = $_POST['password'];
                            $password2 = $_POST['password2'];
                            $password = md5($password);
                            $sql_check = "SELECT COUNT(*) as count FROM user WHERE username = '$username'";
                            $query_check = mysqli_query($conn, $sql_check);
                            $row = mysqli_fetch_assoc($query_check);
                            $userCount = $row['count'];
                            if ($userCount > 0) {
                                echo '<div class="alert alert-warning text-center" role="alert">Username đã tồn tại</div>';
                            } else {
                                $sql = "INSERT INTO user(username, password, role) VALUES('$username', '$password','user')";
                                $query = mysqli_query($conn, $sql);
                                if ($query) {
                                    echo '<div class="alert alert-success text-center" role="alert">Đăng kí thành công</div>';
                                } else {
                                    echo '<div class="alert alert-warning text-center" role="alert">Đăng kí thất bại</div>';
                                }
                            }
                        } else {
                            echo '<div class="alert alert-warning text-center" role="alert">Mật khẩu không khớp, vui lòng nhập lại</div>';
                        }
                    }
                }
                ?>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="material-symbols-outlined">
                            person
                        </span>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Nhập username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                    </div>
                </div>
                <div class="mb-3">

                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="input-group ">
                        <span class="material-symbols-outlined">
                            key
                        </span>
                        <input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class=" col-form-label">
                        Confirm Password</label>
                    <div class="input-group ">
                        <span class="material-symbols-outlined">
                            key
                        </span>
                        <input type="password" class="form-control" id="inputPassword" placeholder="Nhập lại Password" name="password2">
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" name="submitRegister" value="Đăng kí">
                <button class="btn btn-primary"><a href="dang_nhap.php" style="color: white; text-decoration: none">Đăng nhập</a></button>
            </form>
        </div>

    </main>
    <?php include 'footer.php'; ?>
</body>


</html>