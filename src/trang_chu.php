<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ trả lời câu hỏi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/trang_chu.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body onload="starttime()">
    <?php
    include '../function.php';
    include 'navbar.php';
    ?>
    <main>
        <div id="action">
            <h3>
                <a href="../index.php" class="btn"><i class="fa fa-chevron-left" aria-hidden="true"></i> Trở lại</a>
                Khóa học
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
            </h3>
        </div>
        <div class="trang_chu">
            <div>
                <div id="showtime"></div>
                <div id="clear-float"></div>
            </div>
            <div>
                <?php
                // Truy vấn để lấy danh sách câu hỏi
                $Stt = 1;
                $query = "SELECT * FROM cau_hoi WHERE id_khoa_hoc = $id_khoa_hoc AND trang_thai=1";
                $result = mysqli_query($conn, $query);
                // Kiểm tra xem có câu hỏi nào hay không
                if (mysqli_num_rows($result) > 0) {
                    echo '<form action="ket_qua.php?id_khoa_hoc='.$id_khoa_hoc.'" method="POST" id="qa_form" >';
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['trang_thai'] == 1) {
                            if ($row['dang_cau_hoi'] === 'Điền') {
                                echo '<div class="title_ques">Câu ' . $Stt . ': ' . $row['ten_cau_hoi'] . '</div>';
                                echo '<div class="answers">';
                                echo '<div class="qa">';
                                echo <<<EOF
                                <div class="da">
                                    <lable class="label" for="inputGroupSelect01">Nhập đáp án</lable><br/>
                                    <input name="dap_an[{$row['id_cau_hoi']}]" type="text" class="form-control">
                                </div>
                                EOF;
                                echo '</div>';
                                echo  '<img class="img-fluid" width="400px" src="../images/quiz/' . $row['file_tai_len'] . '" alt="">';
                                echo '</div>';
                                $Stt++;
                            } else if ($row['dang_cau_hoi'] === 'Trắc nghiệm') {
                                $answers = explode(",", $row['dap_an']);
                                $answers = array_map(function ($answers) {
                                    return str_replace("(Đúng)", "", $answers);
                                }, $answers);
                                echo '<div class="title_ques">Câu: ' . $Stt . ': ' . $row['ten_cau_hoi'] . '</div>';
                                echo '<div class="answers">';
                                echo '<div class="qa">';
                                foreach ($answers as $answer) {
                                    echo '<div class="da">';
                                    echo '<input class"check_input" name="dap_an[' . $row['id_cau_hoi'] . ']" type="radio" value="' . $answer . '" >';
                                    echo '<p>' . $answer . '</p>';
                                    echo '</div>';
                                }
                                echo '</div>';
                                echo  '<img class="img-fluid" width="400px" src="../images/quiz/' . $row['file_tai_len'] . '" alt="">';
                                echo '</div>';
                                $Stt++;
                            } else if ($row['dang_cau_hoi'] === 'Trắc nghiệm nhiều đáp án') {
                                $answers = explode(",", $row['dap_an']);
                                $answers = array_map(function ($answers) {
                                    return str_replace("(Đúng)", "", $answers);
                                }, $answers);
                                echo '<div class="title_ques">Câu: ' . $Stt . ': ' . $row['ten_cau_hoi'] . '</div>';
                                echo '<div class="answers">';
                                echo '<div class="qa">';
                                foreach ($answers as $answer) {
                                    echo '<div class="da">';
                                    echo '<input class"check_input" name="dap_an[' . $row['id_cau_hoi'] . '][]" type="checkbox" value="' . $answer . '">';
                                    echo '<p>' . $answer . '</p>';
                                    echo '</div>';
                                }
                                echo '</div>';
                                echo  '<img class="img-fluid" width="400px" src="../images/quiz/' . $row['file_tai_len'] . '" alt="">';
                                echo '</div>';
                                $Stt++;
                            } else if ($row['dang_cau_hoi'] === 'Nối câu') {
                                $answers = explode(",", $row['dap_an']);
                                $questions = explode(",", $row['ten_cau_hoi']);
                                $answers = array_map(function ($answers) {
                                    return str_replace("(Đúng)", "", $answers);
                                }, $answers);
                                $numberques = $row['so_luong_dap_an'];
                                echo '<div class="title_ques">Câu: ' . $Stt . '</div>';
                                echo '<div class="answers">';
                                echo '<div class="noi-ques">';
                                for ($i = 0; $i < $numberques; $i++) {
                                    echo '<div class="both"><div class="ques">';
                                    echo '<p> Câu hỏi ' . ($i + 1) . ': ' . $questions[$i] . '</p>';
                                    echo '</div>';
                                    echo '<div class="da">';
                                    echo '<input type="number" class="form-control" name="dap_an[' . $row['id_cau_hoi'] . '][' . $i . ']"><br>';
                                    echo '<p> Đáp án ' . chr(64 + $i + 1) . '. ' . $answers[$i] . '</p>';
                                    echo '</div></div>';
                                }
                                echo '</div>';
                                echo  '<img class="img-fluid" width="400px" src="../images/quiz/' . $row['file_tai_len'] . '" alt="">';
                                echo '</div>';
                                $Stt++;
                            }
                        }
                    }
                    echo '<hr /><input type="submit" name="btn_nop_bai" class="btn submit" id="submitButton" value="Nộp bài"></form>';
                } else {
                    echo '<p>Không có câu hỏi nào.</p>';
                }
                if (isset($_POST['btn_nop_bai'])) {
                    if (isset($_POST['dap_an'])) {
                        var_dump($_POST['dap_an']);
                    }
                }
                ?>
            </div>
        </div>
        <script>
            var tim;
            <?php
                echo 'var min = 1 * '.mysqli_num_rows($result).';';
            ?>
            var sec = 0;
            var f = new Date();

            function starttime() {
                showtime();
            }

            function showtime() {
                if (parseInt(sec) > 0) {
                    sec = parseInt(sec) - 1;
                } else {
                    if (parseInt(min) > 0) {
                        min = parseInt(min) - 1;
                        sec = 59;
                    } else {
                        document.getElementById("showtime").innerHTML = "00 : 00";
                        var submitButton = document.getElementById("submitButton");
                        submitButton.click(); // Kích hoạt sự kiện click của nút submit
                        return;
                    }
                }
                document.getElementById("showtime").innerHTML = (min < 10 ? "0" : "") + min + " : " + (sec < 10 ? "0" : "") + sec;
                tim = setTimeout(showtime, 1000);
            }
        </script>
    </main>
    <?php
    include 'footer.php';
    ?>
</body>

</html>