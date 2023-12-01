<?php
include '../function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm câu hỏi</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- End bootstrap cdn -->
    <link rel="stylesheet" href="../css/them_cau_hoi.css">
</head>

<body>
    <?php
    include 'navbar.php';
    ?>
    <main style="min-height: 100vh; max-width: 100%;">
        <div id="action" style="margin: 20px 0 0 13%;">
            <p class="h3">Khóa học
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
            <a href="bien_tap.php?id_khoa_hoc=<?php echo isset($_GET['id_khoa_hoc']) ? ($_GET['id_khoa_hoc']) : '' ?>" class="btn btn-primary">Trở lại</a>
        </div>
        <div style="margin: 20px 13%;">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name_quiz"><span style="color: red;">*</span>Nhập tên câu hỏi</label>
                    <input class="form-control" type="text" name="ten_cau_hoi" value="<?php echo isset($_POST['ten_cau_hoi']) ? ($_POST['ten_cau_hoi']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="name_quiz">Ảnh cho câu hỏi</label>
                    <input class="form-control" type="file" name="file_tai_len" accept="image/png, image/jpeg">
                </div>
                <div class="form-group">
                    <label for="name_quiz">Dạng câu hỏi</label>
                    <input class="form-control" value="Trắc nghiệm" readonly type="text" name="dang_cau_hoi">
                </div>
                <div class="form-group">
                    <label for="num_choices">Số lượng câu trả lời</label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="number" name="num_choices" min="2" max="10" value="<?php echo isset($_POST['num_choices']) ? $_POST['num_choices'] : '' ?>">
                        <div class="input-group-append">
                            <input class="form-control" type="submit" name="submit" name='tao' value="Tạo">
                        </div>
                    </div>
                    <small class="form-text text-muted">Vui lòng nhập số lượng từ 2 đến 10</small>

                </div>
                <div style="margin: 20px 0 0 0;" class="input-group mb-3">
                    <?php
                    $dap_an_dung = '';
                    $num_choices = isset($_POST['num_choices']) ? intval($_POST['num_choices']) : 4;
                    for ($i = 0; $i < $num_choices; $i++) {
                        $label = chr(65 + $i); // A, B, C, D, ...
                        echo '<div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <div class="input-group-text">';
                        echo "<input class='form-check-input' name='dad' value='dad" . $i . "' type='radio'  >";
                        echo "</div></div>";
                        echo "<input name='da[]' type='text'  class='form-control' aria-label='Text input with radio button' placeholder='Nhập đáp án' value='" . (isset($_POST['da'][$i]) ? $_POST['da'][$i] : '') . "'>";
                        echo '</div>';
                    }
                    $_POST['da'] = isset($_POST['da']) ? $_POST['da'] : array();
                    for ($i = 0; $i < $num_choices; $i++) {
                        if (isset($_POST['dad']) && $_POST['dad'] == 'dad' . $i) {
                            $_POST['da'][$i] .= "(Đúng)";
                            $dap_an_dung = str_replace("(Đúng)", "", $_POST['da'][$i]);
                        }
                    }
                    ?>
                </div>
                <?php
                if (isset($_POST['btn'])) {
                    if (isset($_GET['id_khoa_hoc'])) {
                        if (empty($_POST['ten_cau_hoi'])) {
                            echo "<div class='alert alert-warning text-center' role='alert'>Vui lòng nhập tên câu hỏi</div>";
                        } else if ($_POST['num_choices'] < 2 || $_POST['num_choices'] > 10) {
                            echo "<div class='alert alert-warning text-center' role='alert'>Vui lòng nhập số lượng đáp án và bấm vào nút tạo</div>";
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
                                echo "<div class='alert alert-warning text-center' role='alert'>Vui lòng nhập đầy đủ đáp án</div>";
                            } else {

                                if (empty($_POST['dad'])) {
                                    echo "<div class='alert alert-warning text-center' role='alert'>Bạn chưa chọn đáp án đúng</div>";
                                } else {
                                    for ($i = 0; $i < $num_choices; $i++) {
                                        if (isset($_POST['dad' . $i]) && $_POST['dad' . $i] == 'dad' . $i) {
                                            $_POST['da'][$i] .= "(Đúng)";
                                        }
                                    }
                                    $dap_an = isset($_POST['da']) ? implode(',', $_POST['da']) : '';
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
                                        echo "<div class='alert alert-success text-center' role='alert'>Thêm câu hỏi thành công</div>";
                                    } else {
                                        echo "<div class='alert alert-warning text-center' role='alert'>Thêm câu hỏi thất bại</div>";
                                    }
                                }
                            }
                        }
                    } else {
                        echo "<div class='alert alert-warning text-center' role='alert'>Thêm câu hỏi thất bại</div>";
                    }
                }
                ?>
                <div style="margin: 20px 0 0 0;" class="d-grid">
                    <input class="btn btn-primary btn-block" name="btn" type="submit" value="Thêm câu hỏi">
                </div>
            </form>
        </div>
    </main>
    <?php
    include 'footer.php';
    ?>
</body>

</html>