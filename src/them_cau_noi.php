<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm câu hỏi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/them_cau_hoi.css">
    <link rel="stylesheet" href="../css/general.css">
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
                <a href="bien_tap.php?id_khoa_hoc=<?php echo isset($_GET['id_khoa_hoc']) ? ($_GET['id_khoa_hoc']) : '' ?>" class="btn"><i class="fa fa-chevron-left" aria-hidden="true"></i> Trở lại</a>
                Khóa học
                <?php
                if (isset($_GET['id_khoa_hoc'])) {
                    $id_khoa_hoc = $_GET['id_khoa_hoc'];
                    $sql = "SELECT * FROM khoa_hoc WHERE id_khoa_hoc = $id_khoa_hoc";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['ten_khoa_hoc'];
                }
                ?>
            </p>
        </div>
        <div class="container">
            <form action="" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="name_quiz">Dạng câu hỏi</label>
                    <input class="form-control" value="Nối câu" readonly type="text" name="dang_cau_hoi">
                </div>
                <div class="form-group">
                    <label for="num_choices">Số lượng câu hỏi và trả lời</label>
                    <div class="input-group">
                        <input class="form-control" type="number" name="num_choices" min="2" max="10" value="<?php echo isset($_POST['num_choices']) ? $_POST['num_choices'] : '' ?>">
                        <div class="input-group-append">
                            <input class="btn" type="submit" name="submit" name='tao' value="Tạo">
                        </div>
                    </div>
                    <small class="form-text text-muted">Vui lòng nhập số lượng từ 2 đến 10</small>

                </div>
                <div class="input-group">
                    <?php
                    $num_choices = isset($_POST['num_choices']) ? intval($_POST['num_choices']) : 4;
                    for ($i = 0; $i < $num_choices; $i++) {
                        $labelch = $i + 1;
                        $labelda = chr(65 + $i);
                        echo '<div class="input-group-prepend">';
                        echo "<div><label>Câu hỏi: $labelch</label>";
                        echo "<input name='cauhoi[]' type='text' class='form-control' placeholder='Nhập câu hỏi'></div>";
                        echo "<div><label>Đáp án: $labelda</label>";
                        echo "<input name='da[]' type='text' class='form-control' placeholder='Nhập đáp án'></div>";
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="name_quiz">Ảnh cho câu hỏi</label>
                    <input class="form-control" type="file" name="file_tai_len" accept="image/png, image/jpeg">
                </div>
                <?php
                if (isset($_POST['btn-submit'])) {
                    if (isset($_GET['id_khoa_hoc'])) {
                        if ($_POST['num_choices'] < 2 || $_POST['num_choices'] > 10) {
                            echo "<div class='alert-warning' role='alert'>Vui lòng nhập số lượng đáp án và bấm vào nút tạo</div>";
                        } else {
                            $num_choices = intval($_POST['num_choices']);
                            $answersFilled = true;
                            $quesFilled = true;
                            for ($i = 0; $i < $num_choices; $i++) {
                                if (empty($_POST['da'][$i])) {
                                    $answersFilled = false;
                                    break;
                                }
                                if (empty($_POST['cauhoi'][$i])) {
                                    $quesFilled = false;
                                    break;
                                }
                            }
                            if (!$answersFilled) {
                                echo "<div class='alert-warning' role='alert'>Vui lòng nhập đầy đủ đáp án</div>";
                            } else if (!$quesFilled) {
                                echo "<div class='alert-warning' role='alert'>Vui lòng nhập đầy đủ câu hỏi</div>";
                            } else {
                                $dap_an_dung = '';
                                for ($i = 0; $i < $num_choices; $i++) {
                                    $cau_hoi = isset($_POST['cauhoi'][$i]) ? $_POST['cauhoi'][$i] : '';
                                    $dap_an = isset($_POST['da'][$i]) ? $_POST['da'][$i] : '';
                                    $dap_an_dung = $dap_an_dung . "${cau_hoi} - ${dap_an}" . (($i == $num_choices - 1) ? '' : ',');
                                }
                                $cau_hoi_da[] = ['cau_hoi' => $cau_hoi, 'dap_an' => $dap_an];
                                shuffle($_POST['da']);
                                $dap_an = isset($_POST['da']) ? implode(',', $_POST['da']) : '';
                                $tac_gia =  $_SESSION['login']['username'];
                                $id_khoa_hoc = $_GET['id_khoa_hoc'];
                                $id_user = $_SESSION['login']['id'];
                                $ten_cau_hoi = isset($_POST['cauhoi']) ? implode(',', $_POST['cauhoi']) : '';;
                                $dang_cau_hoi = $_POST['dang_cau_hoi'];
                                $file_tai_len = $_FILES['file_tai_len']['name'];
                                $tmp_name = $_FILES['file_tai_len']['tmp_name'];
                                $path = "../images/quiz/" . $file_tai_len;
                                move_uploaded_file($tmp_name, $path);
                                $sql = "INSERT INTO `cau_hoi`(`ten_cau_hoi`, `dang_cau_hoi`, `dap_an`, `file_tai_len`,`id_khoa_hoc`,`trang_thai`,`id_user`,`so_luong_dap_an`,`dap_an_dung`) VALUES ('$ten_cau_hoi','$dang_cau_hoi','$dap_an','$file_tai_len','$id_khoa_hoc',0,'$id_user','$num_choices','$dap_an_dung')";
                                $query = mysqli_query($conn, $sql);
                                if ($query) {
                                    echo "<div class='alert-success' role='alert'>Thêm câu hỏi thành công</div>";
                                } else {
                                    echo "<div class='alert-warning' role='alert'>Thêm câu hỏi thất bại</div>";
                                }
                            }
                        }
                    } else {
                        echo "<div class='alert-warning' role='alert'>Thêm câu hỏi thất bại</div>";
                    }
                }
                ?>
                <div style="margin: 20px 0 0 0;" class="d-grid">
                    <input class="btn" name="btn-submit" type="submit" value="Thêm câu hỏi">
                </div>
            </form>
        </div>
    </main>
    <?php
    include 'footer.php';
    ?>
</body>

</html>