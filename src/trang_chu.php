<?php
include '../function.php';

// Kiểm tra xác nhận nộp bài

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ trả lời câu hỏi</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- End bootstrap cdn -->
    <link rel="stylesheet" href="../css/xem_truoc.css">
    <style>
        img {
            max-width: 400px;
        }

        a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>

<body>
    <?php
    include 'navbar.php';
    ?>
    <main style="min-height: 100vh; max-width: 100%;">

        <div id="action" style="margin: 20px 0 0 13%;">
            <p class="h3">Khóa học
                <?php
                if (isset($_GET['id_khoa_hoc']) && $_GET['id_khoa_hoc'] != '') {
                    $id_khoa_hoc = $_GET['id_khoa_hoc'];
                    $sql = "SELECT * FROM khoa_hoc WHERE id_khoa_hoc = $id_khoa_hoc";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['ten_khoa_hoc'];
                } else {
                    echo "";
                }
                ?>
            </p>
            <a href="khoa_hoc.php" class="btn btn-primary">Trở lại</a>

            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                Thêm câu hỏi
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="them_cau_hoi.php?id_khoa_hoc=<?php echo $id_khoa_hoc ?>">Câu hỏi điền</a></li>
                <li><a class="dropdown-item" href="them_cau_hoi_tn.php?id_khoa_hoc=<?php echo $id_khoa_hoc ?>">Câu hỏi trắc nghiệm 1 đáp án</a></li>
                <li><a class="dropdown-item" href="them_cau_hoi.php?id_khoa_hoc=<?php echo $id_khoa_hoc ?>">Câu hỏi nối</a></li>
            </ul>
        </div>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 0 0 0; ">
            <?php
            // Truy vấn để lấy danh sách câu hỏi
            echo '<div class="card" style="width: 100rem; margin: 10px;">';
            echo '<div class="card-body">';
            $Stt = 1;
            $query = "SELECT * FROM cau_hoi WHERE id_khoa_hoc = $id_khoa_hoc";
            $result = mysqli_query($conn, $query);
            // Kiểm tra xem có câu hỏi nào hay không
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['dang_cau_hoi'] === 'Điền') {
                        echo '<div>Câu: ' . $Stt . '</div>';
                        echo '<div>' . $row['ten_cau_hoi'] . '</div';
                        echo '<div class="input-group mb-3">
                        <lable class="input-group-text" for="inputGroupSelect01">Nhập đáp án</lable>
                        <input name="dap_an" type="text" class="form-control" value=" ">
                        </div>';
                        $Stt++;
                    } else if ($row['dang_cau_hoi'] === 'Trắc nghiệm') {
                        $answers = explode(",", $row['dap_an']);
                        $answers = array_map(function ($answers) {
                            return str_replace("(Đúng)", "", $answers);
                        }, $answers);
                        echo '<div>Câu: ' . $Stt . '</div>';
                        echo '<div>' . $row['ten_cau_hoi'] . '</div>';
                        echo  '<img class="img-fluid" src="../images/quiz/' . $row['file_tai_len'] . '" alt="">';
                        foreach ($answers as $answer) {
                            echo '<div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <div class="input-group-text">';
                            echo '<input class"form-check-input" name="da_tl" type="radio"' . (isset($_POST['da_tl']) && $_POST['da_tl'] === $answer ? 'checked' : '') . ' >';
                            echo '</div>
                            </div>';
                            echo '<input type="text" class="form-control" aria-label="Text input with radio button" value="' . $answer . '" readonly><br>';
                            echo '</div>';
                        }
                        echo '<hr>';
                        $Stt++;
                    }
                }
            } else {
                echo '<p>Không có câu hỏi nào.</p>';
            }
            echo '</div> </div>';
            ?>
            <form action="" method="post">
            <input type="submit" name="btn_nop_bai" class="btn btn-danger" aria-label="Text input with radio button" value="Nop bai">
            <?php
            if (isset($_POST['btn_nop_bai'])) {
                
                echo 'nop bai thanh cong';
            }
            ?>
            </form>
        </div>

    </main>
    <?php
    include 'footer.php';
    ?>
</body>

</html>