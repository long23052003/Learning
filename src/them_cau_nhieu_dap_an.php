<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm câu hỏi nhiều đáp án</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/general.css" >
    <link rel="stylesheet" href="../css/them_cau_hoi.css" >
    <link rel="stylesheet" href="../css/footer.css" >
</head>

<body>
    <?php
    include '../function.php';
    include 'navbar.php';
    ?>
    <main>
        <div id="action" >
            <p class="h3">
                <a href="bien_tap.php?id_khoa_hoc=<?php echo isset($_GET['id_khoa_hoc']) ? ($_GET['id_khoa_hoc']) : '' ?>" class="btn"><i class="fa fa-chevron-left" aria-hidden="true"></i> Trở lại</a>
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
                    <label for="name_quiz"><span style="color: red;">*</span>Nhập tên câu hỏi</label>
                    <input class="form-control" type="text" name="ten_cau_hoi" value="<?php echo isset($_POST['ten_cau_hoi']) ? ($_POST['ten_cau_hoi']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="name_quiz">Dạng câu hỏi</label>
                    <input class="form-control" value="Trắc nghiệm nhiều đáp án" readonly type="text" name="dang_cau_hoi">
                </div>
                <div class="form-group">
                    <label for="num_choices">Số lượng câu trả lời</label>
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
                        echo '<div class="input-group-prepend">';
                        echo "<input class='form-check-input' name='dad[]' value='dad" . $i . "' type='checkbox'  >";
                        echo "<input name='da[]' type='text'  class='form-control' placeholder='Nhập đáp án' value='" . (isset($_POST['da'][$i]) ? $_POST['da'][$i] : '') . "'>";
                        echo '</div>';
                    }
                    $_POST['da'] = isset($_POST['da']) ? $_POST['da'] : array();
                    ?>
                </div>
                <div class="form-group">
                    <label for="name_quiz">Ảnh cho câu hỏi</label>
                    <input class="form-control" type="file" name="file_tai_len" accept="image/png, image/jpeg">
                </div>
                <?php
                if (isset($_POST['btn'])) {
                    if (isset($_GET['id_khoa_hoc'])) {
                        if (empty($_POST['ten_cau_hoi'])) {
                            echo "<div class='alert-warning' role='alert'>Vui lòng nhập câu hỏi</div>";
                        } else if ($_POST['num_choices'] < 2 || $_POST['num_choices'] > 10) {
                            echo "<div class='alert-warning' role='alert'>Vui lòng nhập số lượng đáp án và bấm vào nút tạo</div>";
                        } else {
                            $num_choices = intval($_POST['num_choices']);
                            $answersFilled = true;

                            for ($i = 0; $i < $num_choices; $i++) {
                                if (empty($_POST['da'][$i])) {
                                    $answersFilled = false;
                                    break;
                                }
                            }
                            if (!$answersFilled) {
                                echo "<div class='alert-warning' role='alert'>Vui lòng nhập đầy đủ đáp án</div>";
                            } else {

                                if (empty($_POST['dad'])) {
                                    echo "<div class='alert-warning' role='alert'>Bạn chưa chọn đáp án đúng</div>";
                                } else {
                                    $dap_an_dung = '';
                                    for ($i = 0; $i < $num_choices; $i++) {
                                        if (isset($_POST['dad'])) {
                                            for($j = 0; $j < sizeof($_POST['dad']); $j++){
                                                if($_POST['dad'][$j] == 'dad' . $i){
                                                    $_POST['da'][$i] .= "(Đúng)";
                                                    $dap_an_dung = $dap_an_dung.str_replace("(Đúng)", ";", $_POST['da'][$i]);
                                                }
                                            }
                                        }
                                    }
                                    $dap_an_dung = rtrim($dap_an_dung, ';');
                                    $dap_an = isset($_POST['da']) ? implode(';', $_POST['da']) : '';
                                    $tac_gia =  $_SESSION['login']['username'];
                                    $id_khoa_hoc = $_GET['id_khoa_hoc'];
                                    $id_user = $_SESSION['login']['id'];
                                    $ten_cau_hoi = $_POST['ten_cau_hoi'];
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
                        }
                    } else {
                        echo "<div class='alert-warning' role='alert'>Thêm câu hỏi thất bại! Vui lòng truy cập khóa học.</div>";
                    }
                }
                ?>
                <div style="margin: 20px 0 0 0;" class="d-grid">
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