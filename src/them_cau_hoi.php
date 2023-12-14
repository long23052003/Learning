<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm câu hỏi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/them_cau_hoi.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>
    <?php
    include '../function.php';
    include 'navbar.php';
    ?>
    <main>
        <div id="action">
        <p class="h3">
            <a href="./bien_tap.php?id_khoa_hoc=<?php echo isset($_GET['id_khoa_hoc']) ? ($_GET['id_khoa_hoc']) : '' ?>" class="btn"><i class="fa fa-chevron-left" aria-hidden="true"></i> Trở lại</a>
            <span class="title_kh">Khóa học
                <?php
                if (isset($_GET['id_khoa_hoc'])) {
                    $id_khoa_hoc = $_GET['id_khoa_hoc'];
                    $sql = "SELECT * FROM khoa_hoc WHERE id_khoa_hoc = $id_khoa_hoc";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['ten_khoa_hoc'];
                }
                ?></span>
            </p>
        </div>
        <div class="container">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name_quiz"><span style="color: red;">*</span>Nhập tên câu hỏi</label><br />
                    <input class="form-control" type="text" name="ten_cau_hoi" id="" value="<?php echo (isset($_POST['ten_cau_hoi']) ? (htmlspecialchars($_POST['ten_cau_hoi'])) : '' )?>">
                </div>
                <div class="form-group">
                    <label for="name_quiz">Ảnh cho câu hỏi</label><br />
                    <input class="form-control" type="file" name="file_tai_len" id="" accept="image/png, image/jpeg">
                </div>
                <div class="form-group">
                    <label for="name_quiz">Dạng câu hỏi</label><br />
                    <input class="form-control" value="Điền" readonly type="text" name="dang_cau_hoi" id="">
                </div>
                <div class='input-group mb-3'>
                    <input name='da' type='text' class='form-control' placeholder='Nhập đáp án' value="<?php echo isset($_POST['da']) ? ($_POST['da']) : '' ?>">
                </div>
                <?php
                if (isset($_POST['btn'])) {
                    if (isset($_GET['id_khoa_hoc'])) {
                        if (empty($_POST['ten_cau_hoi'])) {
                            echo "<div class='alert-warning' role='alert'>Vui lòng nhập tên câu hỏi!</div>";
                        } else if (empty($_POST['da'])) {
                            echo "<div class='alert-warning' role='alert'>Vui lòng nhập đáp án!</div>";
                        } else {
                            $tac_gia =  $_SESSION['login']['username'];
                            $id_khoa_hoc = $_GET['id_khoa_hoc'];
                            $id_user = $_SESSION['login']['id'];
                            $ten_cau_hoi = $_POST['ten_cau_hoi'];
                            $dang_cau_hoi = $_POST['dang_cau_hoi'];
                            $da = $_POST['da'];
                            $file_tai_len = $_FILES['file_tai_len']['name'];
                            $tmp_name = $_FILES['file_tai_len']['tmp_name'];
                            $path = "../images/quiz/" . $file_tai_len;
                            move_uploaded_file($tmp_name, $path);
                            $sql = "INSERT INTO `cau_hoi`(`ten_cau_hoi`, `dang_cau_hoi`, `dap_an`, `file_tai_len`,`id_khoa_hoc`,`trang_thai`,`id_user`,`dap_an_dung`) VALUES ('$ten_cau_hoi','$dang_cau_hoi','$da','$file_tai_len','$id_khoa_hoc',0,'$id_user','$da')";
                            $query = mysqli_query($conn, $sql);
                            if ($query) {
                                echo "<div class='alert-success' role='alert'>Thêm câu hỏi thành công!</div>";
                            } else {
                                echo "<div class='alert-warning' role='alert'>Thêm câu hỏi thất bại!</div>";
                            }
                        }
                    } else {
                        echo "<div class='alert-warning' role='alert'>Thêm câu hỏi thất bại! Vui lòng truy cập khóa học.</div>";
                    }
                }
                ?>
                <div>
                    <input class="btn" name="btn" type="submit" value="Thêm câu hỏi">
                </div>

            </form>
        </div>

    </main>

    <?php
    include 'footer.php';
    ?>

</body>


</html>