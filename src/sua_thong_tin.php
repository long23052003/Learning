<?php
include '../function.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang cá nhân</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/trang_ca_nhan.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/bien_tap.css">
</head>
<?php
include 'navbar.php';
?>

<body>
    <main>
        <div class="title">

            <h2><a href="trang_ca_nhan.php" class="btn_back"><i class="fa fa-chevron-left" aria-hidden="true"></i>Trở lại</a>Thông tin</h2>
        </div>
        <div class="container-info">
            <div class="info">
            <div id="info-img">
                <div class="">
                    <img class="shadow" src="<?php
                                                $sql = "SELECT * FROM `user` WHERE id_user = '{$_SESSION['login']['id']}'";
                                                $result = mysqli_query($conn, $sql);
                                                $row = mysqli_fetch_assoc($result);
                                                echo '../images/avt/' . $row['img_avt'];
                                                ?>" alt="">
                </div>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div id="info-text">
                <label for="name" class="text">Tên</label>
                <input type="text" name="name" placeholder="Name"> <br>
                <label for="name" class="text">Ngày sinh</label>
                <input type="date" name="date" placeholder="Date"> <br>
                <label for="name" class="text">Avatar</label>
                <input type="file" name="file_img_new"> <br>
                <input class="btn btn_duyet" name="btn" type="submit" value="Đồng ý">
                </div>
            </form>
            <?php
if (isset($_POST['btn'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $fileAvt = isset($_FILES['file_img_new']['name']) ? $_FILES['file_img_new']['name'] : '';

    if (!empty($name) || !empty($date) || !empty($fileAvt)) {
        $updateQuery = '';

        if (!empty($name)) {
            $updateQuery .= "`name` = '$name', ";
        }

        if (!empty($date)) {
            $updateQuery .= "`doB` = '$date', ";
        }

        if (!empty($fileAvt)) {
            $fileNameAvt = $_FILES['file_img_new']['tmp_name'];
            $path = "../images/avt/" . $fileAvt;
            move_uploaded_file($fileNameAvt, $path);

            $updateQuery .= "`img_avt` = '$fileAvt', ";
        }

        $updateQuery = rtrim($updateQuery, ', ');

        if (!empty($updateQuery)) {
            $sql = "UPDATE `user` SET $updateQuery WHERE `user`.`id_user` = '{$_SESSION['login']['id']}'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<script>alert('Cập nhật thành công')</script>";
                echo "<script>window.location.href = 'sua_thong_tin.php'</script>";
            } else {
                echo "<script>alert('Cập nhật thất bại')</script>";
            }
        } else {
            echo "<script>alert('Vui lòng nhập thông tin')</script>";
        }
    } else {
        echo "<script>alert('Vui lòng nhập thông tin')</script>";
    }
}
?>

        </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>