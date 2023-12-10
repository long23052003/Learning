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
            <h2>Thông tin</h2>
        </div>
        <div class="container-info">
            <div class="info">
                <div id="info-img">
                    <div class="">
                        <img class="shadow" src="<?php
                                                    $sql = "SELECT * FROM `user` WHERE id_user = '{$_SESSION['login']['id']}'";
                                                    $result = mysqli_query($conn, $sql);
                                                    $row = mysqli_fetch_assoc($result);
                                                    echo '../images/avt/' . $row['img_avt']; // Add timestamp as a query parameter
                                                    ?>" alt="">
                    </div>
                </div>
                <div id="info-text">
                    <div class="text">
                        <h3>Họ và tên: <?php
                                        $sql = "SELECT * FROM `user` WHERE id_user = '{$_SESSION['login']['id']}'";
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        echo $row['name'];
                                        ?>
                        </h3>
                    </div>
                    <div class="text">
                        <h3>Ngày sinh: <?php
                                        $sql = "SELECT * FROM `user` WHERE id_user = '{$_SESSION['login']['id']}'";
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        echo $row['doB'];
                                        ?>
                        </h3>
                    </div>
                    <div class="text">
                        <h3> Khoa: <?php
                                    $sql = "SELECT * FROM `user` JOIN khoa ON user.id_khoa = khoa.id_khoa WHERE id_user = '{$_SESSION['login']['id']}'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['ten_khoa'] ?>
                        </h3>
                    </div>
                    <div class="text">
                        <form action="" method="post">
                        <button class="btn btn-table"><a href="sua_thong_tin.php">Sửa thông tin</a></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>