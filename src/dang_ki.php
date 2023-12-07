<?php include '../function.php';
unset($_SESSION['login']); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng kí</title>
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/dang_ki.css">
</head>

<body>
    <form class="register-form" method="POST" enctype="multipart/form-data">
        <h2 id="title">Đăng ký ELearning-K71</h2>
        <?php
        if (isset($_POST['submitRegister'])) {
            if (empty($_POST['username'])) {
                echo '<div class="alert-warning" role="alert">Vui lòng nhập tên đăng nhập!</div>';
            } else if (empty($_POST['password'])) {
                echo '<div class="alert-warning" role="alert">Vui lòng nhập mật khẩu!</div>';
            } else if (empty($_POST['password2'])) {
                echo '<div class="alert-warning" role="alert">Vui lòng nhập lại mật khẩu!</div>';
            } else if (preg_match('/\s/', $_POST['username'])) {
                echo '<div class="alert-warning" role="alert">Tên người dùng viết liền không dấu!</div>';
            } else {
                if ($_POST['password'] === $_POST['password2']) {
                    $fileAvt = $_FILES['file_img']['name'];
                    $fileNameAvt = $_FILES['file_img']['tmp_name'];
                    $path = "../images/avt/" . $fileAvt;
                    move_uploaded_file($fileNameAvt, $path);
                    $doB = $_POST['doB'];
                    $name = $_POST['name'];
                    $khoa = $_POST['khoa'];
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $password2 = $_POST['password2'];
                    $password = md5($password);
                    $sql_check = "SELECT COUNT(*) as count FROM user WHERE username = '$username'";
                    $query_check = mysqli_query($conn, $sql_check);
                    $row = mysqli_fetch_assoc($query_check);
                    $userCount = $row['count'];
                    if ($userCount > 0) {
                        echo '<div class="alert-warning" role="alert">Tên người dùng đã tồn tại!</div>';
                    } else {
                        $sql = "INSERT INTO user(username, password, role,img_avt,name,doB,id_khoa) VALUES('$username', '$password','user','$fileAvt','$name','$doB','$khoa')";
                        $query = mysqli_query($conn, $sql);
                        if ($query) {
                            header('Location: ./dang_nhap.php');
                        } else {
                            echo '<div class="alert-warning" role="alert">Đăng kí thất bại!</div>';
                        }
                    }
                } else {
                    echo '<div class="alert-warning" role="alert">Mật khẩu không khớp, vui lòng nhập lại</div>';
                }
            }
        }
        ?>
        <div class="form-input">
            <label for="name" class="form-label">Tên</label>
            <input type="text" id="username" name="name" placeholder="Nhập tên của bạn" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">

        </div>
        <div class="form-input">
            <label for="username" class="form-label">Tên người dùng</label>
            <input type="text" id="username" name="username" placeholder="Nhập tên người dùng" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">

        </div>
        <div class="form-input">
            <label for="inputPassword">Mật khẩu</label>

            <input type="password" id="inputPassword" placeholder="Nhập mật khẩu" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
        </div>
        <div class="form-input">
            <label for="inputPassword">
                Nhập lại mật khẩu</label>
            <input type="password" id="inputPassword" placeholder="Nhập lại mật khẩu" name="password2" value="<?php echo isset($_POST['password2']) ? $_POST['password2'] : ''; ?>">
        </div>
        <div class="form-input">
            <label for="inputPassword">
                Ngày sinh</label>
            <input type="date" id="inputPassword" placeholder="" name="doB">
        </div>
        <div class="form-input">
            <label for="">
                Khoa</label>
            <select class="form-select" aria-label="Default select example" name="khoa">
                <option value="" <?php echo empty($_POST['khoa']) ? 'selected' : ''; ?>>Chọn khoa</option>
                <option value="1" <?php echo isset($_POST['khoa']) && $_POST['khoa'] == '1' ? 'selected' : ''; ?>>Công nghệ thông tin</option>
                <option value="2" <?php echo isset($_POST['khoa']) && $_POST['khoa'] == '2' ? 'selected' : ''; ?>>Văn</option>
                <option value="3" <?php echo isset($_POST['khoa']) && $_POST['khoa'] == '3' ? 'selected' : ''; ?>>Hóa</option>
            </select>

        </div>
        <div class="input-img">
            <label for="btn-img" id="img-label">Ảnh đại diện</label>
            <input type="file" placeholder="Recipient's username" id="btn-img" accept="image/png, image/jpeg" name='file_img' hidden onchange="displayFileName(this)">
        </div>
        <input type="submit" class="btn-submit" name="submitRegister" value="Đăng kí">
        <button class="btn-login"><a href="dang_nhap.php">Đăng nhập</a></button>
    </form>
    <script>
        function displayFileName(input) {
            var label = document.getElementById("img-label");
            if (input.files.length > 0) {
                label.textContent = "Ảnh đại diện: " + input.files[0].name;
            } else {
                label.textContent = "Ảnh đại diện";
            }
        }
    </script>
</body>

</html>