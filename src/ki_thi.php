<?php include '../function.php';
if (isset($_GET['id_khoa_hoc']) && $_GET['id_khoa_hoc'] != '' && isset($_GET['id_ki_thi']) && $_GET['id_ki_thi'] != '' && $_SESSION['login']['role'] == 'user') {
    $sql_check_gh = "SELECT diem_user.*, ki_thi.gioi_han FROM diem_user JOIN ki_thi ON diem_user.id_ki_thi=ki_thi.id_ki_thi WHERE diem_user.id_user = {$_SESSION['login']['id']} AND diem_user.id_khoa_hoc ={$_GET['id_khoa_hoc']}";
    $result_check_gh = mysqli_query($conn, $sql_check_gh);
    $sql_gh= "SELECT * FROM ki_thi WHERE id_ki_thi = {$_GET['id_ki_thi']}";
    $result_gh = mysqli_query($conn, $sql_gh);
    $row_check_gh = mysqli_fetch_assoc($result_gh);
    $gh=$row_check_gh['gioi_han'];
    if (mysqli_num_rows($result_check_gh) >= $gh) {
        echo "<script type='text/javascript'>alert('Bạn đã vượt quá số lần thi cho phép')
     ;
     window.location.href='quan_li_ki_thi.php';
     </script>";
    }
} else {
    header('location: quan_li_ki_thi.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thi </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/trang_chu.css">
    <link rel="stylesheet" href="../css/footer.css">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body onload="starttime() ">
    <?php

    include 'navbar.php';
    ?>
    <main>
        <div id="action">
            <p class="h3">
                <span class="title_kh"><b>
                        <?php
                         if (isset($_GET['id_ki_thi'])) {
                            $id_ki_thi = $_GET['id_ki_thi'];
                            $id_khoa_hoc = $_GET['id_khoa_hoc'];
                            $sql = "SELECT * FROM ki_thi WHERE id_ki_thi = $id_ki_thi";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            echo $row['ten_ki_thi'];
                        }
                        ?></b></span>
            </p>
        </div>
        <div class="trang_chu">
            <div>
                <?php
                if (isset($_GET['id_khoa_hoc']) && $_GET['id_khoa_hoc'] != '' && isset($_GET['id_ki_thi']) && $_GET['id_ki_thi'] != '') {
                    $query_thi = "SELECT * FROM ki_thi WHERE id_ki_thi = '{$_GET['id_ki_thi']}' AND id_khoa_hoc = '{$_GET['id_khoa_hoc']}'";
                    $result_thi = mysqli_query($conn, $query_thi);
                    $row_thi = mysqli_fetch_assoc($result_thi);
                    $gioi_han = $row_thi['gioi_han'];
                    $id_khoa_hoc = $row_thi['id_khoa_hoc'];
                    $id_ki_thi = $row_thi['id_ki_thi'];
                    $so_cau = $row_thi['so_cau'];
                    $thoi_gian = $row_thi['time_thi'];
                    $query = "SELECT * FROM cau_hoi WHERE id_khoa_hoc = $id_khoa_hoc AND trang_thai=1 and id_user != {$_SESSION['login']['id']} ORDER BY RAND() LIMIT {$so_cau}";
                    $result = mysqli_query($conn, $query);
                    // Kiểm tra xem có câu hỏi nào hay không
                    if (mysqli_num_rows($result) > 0) {
                        echo '<div id="showtime"></div>
                                <div id="clear-float"></div>';
                    }
                } else {
                    header('location: quan_li_ki_thi.php');
                }
                ?>
            </div>
            <div>
                <?php
                if (isset($_POST['btn_nop_bai'])) {
                    header('location: ket_qua_thi.php?id_khoa_hoc=' . $id_khoa_hoc . '&id_ki_thi=' . $id_ki_thi . '');
                }
                if (isset($_GET['id_khoa_hoc']) && $_GET['id_khoa_hoc'] != '' && isset($_GET['id_ki_thi']) && $_GET['id_ki_thi'] != '') {
                    if ($_SESSION['login']['role'] === 'user') {
                        // Truy vấn để lấy danh sách câu hỏi
                        $Stt = 1;
                        $query = "SELECT * FROM cau_hoi WHERE id_khoa_hoc = $id_khoa_hoc AND trang_thai=1 AND id_user != {$_SESSION['login']['id']} ORDER BY RAND() LIMIT {$so_cau}";
                        $result = mysqli_query($conn, $query);
                        // Kiểm tra xem có câu hỏi nào hay không
                        if (mysqli_num_rows($result) > 0) {
                            echo '<form action="" method="POST" id="qa_form">';
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['trang_thai'] == 1) {
                                    if ($row['dang_cau_hoi'] === 'Điền') {
                                        echo '<div class="title_ques">Câu ' . $Stt . ': ' . htmlspecialchars($row['ten_cau_hoi']) . '</div>';
                                        echo '<div class="answers">';
                                        echo '<div class="qa">';
                                        echo '
                                        <div class="da">
                                            <label class="label" for="inputGroupSelect01">Nhập đáp án</label><br/>
                                            <input name="dap_an[' . $row['id_cau_hoi'] . ']" type="text" class="form-control">
                                        </div>';
                                        echo '</div>';
                                        echo  '<img class="img-fluid" width="400px" src="../images/quiz/' . $row['file_tai_len'] . '" alt="">';
                                        echo '</div>';
                                        $Stt++;
                                        // Inside the section where you save user responses

                                    } else if ($row['dang_cau_hoi'] === 'Trắc nghiệm') {
                                        $answers = explode(";", ($row['dap_an']));
                                        $answers = array_map(function ($answers) {
                                            return str_replace("(Đúng)", "", $answers);
                                        }, $answers);
                                        echo '<div class="title_ques">Câu: ' . $Stt . ': ' . htmlspecialchars($row['ten_cau_hoi']) . '</div>';
                                        echo '<div class="answers">';
                                        echo '<div class="qa">';
                                        foreach ($answers as $answer) {
                                            echo '<div class="da">';
                                            echo '<input class"check_input" name="dap_an[' . $row['id_cau_hoi'] . ']" type="radio" value="' . htmlspecialchars($answer) . '" >';
                                            echo '<p>' . htmlspecialchars($answer) . '</p>';
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                        echo  '<img class="img-fluid" width="400px" src="../images/quiz/' . $row['file_tai_len'] . '" alt="">';
                                        echo '</div>';
                                        $Stt++;
                                    } else if ($row['dang_cau_hoi'] === 'Trắc nghiệm nhiều đáp án') {
                                        $answers = explode(";", ($row['dap_an']));
                                        $answers = array_map(function ($answers) {
                                            return str_replace("(Đúng)", "", $answers);
                                        }, $answers);
                                        echo '<div class="title_ques">Câu: ' . $Stt . ': ' . htmlspecialchars($row['ten_cau_hoi']) . '</div>';
                                        echo '<div class="answers">';
                                        echo '<div class="qa">';
                                        foreach ($answers as $answer) {
                                            echo '<div class="da">';
                                            echo '<input class"check_input" name="dap_an[' . $row['id_cau_hoi'] . '][]" type="checkbox" value="' . htmlspecialchars($answer) . '">';
                                            echo '<p>' . htmlspecialchars($answer) . '</p>';
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                        echo  '<img class="img-fluid" width="400px" src="../images/quiz/' . $row['file_tai_len'] . '" alt="">';
                                        echo '</div>';
                                        $Stt++;
                                    } else if ($row['dang_cau_hoi'] === 'Nối câu') {
                                        $answers = explode(";", ($row['dap_an']));
                                        $questions = explode(";", ($row['ten_cau_hoi']));
                                        $answers = array_map(function ($answers) {
                                            return str_replace("(Đúng)", "", $answers);
                                        }, $answers);
                                        $numberques = $row['so_luong_dap_an'];
                                        $question_id = $row['id_cau_hoi'];
                                        $user_answer = '';
                                        echo '<div class="title_ques">Câu ' . $Stt . ': Nối 2 cột sau để tạo thành đáp án đúng</div>';
                                        echo '<div class="answers">';
                                        echo '<div class="noi-ques">';
                                        for ($i = 0; $i < $numberques; $i++) {
                                            echo '<div class="both"><div class="ques">';
                                            echo '<p> Câu hỏi ' . ($i + 1) . ': ' . htmlspecialchars($questions[$i]) . '</p>';
                                            echo '</div>';
                                            echo '<div class="da">';
                                            echo '</div>';
                                            echo '<div class="dropdown">';
                                            echo '<select name="dap_an_dung[' . $row['id_cau_hoi'] . '][' . $i . ']" class="form-control">';
                                            for ($j = 0; $j < $numberques; $j++) {
                                                echo '<option value="' . htmlspecialchars($answers[$j])  . '"> Đáp án ' . chr(64 + $j + 1) . '. ' . htmlspecialchars($answers[$j]) . '</option>';
                                            }
                                            echo '</select>';
                                            echo '</div></div>';
                                            $selected_answers = isset($_POST['dap_an_dung'][$row['id_cau_hoi']]) ? ($_POST['dap_an_dung'][$row['id_cau_hoi']][$i]) : '';
                                            $user_answer .= ($questions[$i]) . " - ${selected_answers}" . (($i == $numberques - 1) ? '' : ';');
                                        }
                                        echo '</div>';
                                        echo  '<img class="img-fluid" width="400px" src="../images/quiz/' . $row['file_tai_len'] . '" alt="">';
                                        echo '</div>';
                                        $Stt++;
                                        $_SESSION['user_answers'][$question_id] =  $user_answer;
                                    }
                                }
                            }
                            echo '<hr /><input type="submit" name="btn_nop_bai" class="btn submit" id="submitButton" value="Nộp bài" onclick="submitForm()">
                                <input type="hidden" id="duration" name="duration"></form>';
                        } else {
                            echo '<p>Không có câu hỏi nào.</p>';
                        }

                        if (isset($_POST['btn_nop_bai'])) {
                            $time_duration = $_POST['duration'];
                            $cau_dung = 0;
                            $query = "SELECT * FROM cau_hoi WHERE id_khoa_hoc = $id_khoa_hoc AND trang_thai=1";
                            $result = mysqli_query($conn, $query);
                            $number_ques = mysqli_num_rows($result);
                            $row = mysqli_fetch_assoc($result);
                            if ($number_ques > 0) {
                                if (isset($_POST['dap_an'])) {
                                    // Save user answers to session instead of the database
                                    if ($row['dang_cau_hoi'] != 'Nối câu') {
                                        foreach ($_POST['dap_an'] as $question_id => $user_answer) {
                                            $_SESSION['user_answers'][$question_id] = $user_answer;
                                        }
                                    }
                                    if (isset($_SESSION['user_answers'])) {
                                        foreach ($_SESSION['user_answers'] as $question_id => $user_answer) {
                                            $sql_question = "SELECT * FROM cau_hoi WHERE id_cau_hoi = $question_id";
                                            $result_question = mysqli_query($conn, $sql_question);
                                            $row_question = mysqli_fetch_assoc($result_question);
                                            if ($row_question['dang_cau_hoi'] === 'Nối câu') {
                                                $answers = isset($user_answer) ? explode(";", ($user_answer)) : array();
                                                $answers_check = isset($row_question['dap_an_dung']) ? explode(";", ($row_question['dap_an_dung'])) : array();

                                                if (array_diff($answers, $answers_check) == null) {
                                                    $cau_dung++;
                                                } else {
                                                    $cau_dung += 0;
                                                }
                                            } else if ($row_question['dang_cau_hoi'] === 'Trắc nghiệm nhiều đáp án') {
                                                $answers = isset($user_answer) ? (is_array($user_answer) ? $user_answer : array($user_answer)) : array();
                                                $answers_check = isset($row_question['dap_an_dung']) ? explode(";", ($row_question['dap_an_dung'])) : array();
                                                if (array_diff($answers, $answers_check) == null) {
                                                    $cau_dung++;
                                                } else {
                                                    $cau_dung += 0;
                                                }
                                            } else {
                                                $answers_check = isset($row_question['dap_an_dung']) ? ($row_question['dap_an_dung']) : '';
                                                if ($answers_check === $user_answer) {
                                                    $cau_dung++;
                                                } else {
                                                    $cau_dung += 0;
                                                }
                                            }
                                        }
                                        // echo '<div class="alert alert-success" role="alert">Nộp bài thành công </div>';
                                        // echo '<a href="test.php?id_khoa_hoc=' . $id_khoa_hoc . '" class="btn">Xem kết quả</a>';
                                    }
                                }
                                $score = (floatval($cau_dung) / 10) * 100;
                                $hours = floor($time_duration / 3600000);  // 1 hour = 3600000 milliseconds
                                $minutes = floor(($time_duration % 3600000) / 60000);  // 1 minute = 60000 milliseconds
                                $seconds = floor((($time_duration % 3600000) % 60000) / 1000);  // 1 second = 1000 milliseconds

                                $formatted_duration = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
                                // echo "Time Duration: " . $formatted_duration;
                                // echo $score;
                                // echo '<pre>';
                                // print_r(($_SESSION['user_answers']));
                                // echo '</pre>';
                                $sql_diem = "INSERT INTO diem_user (id_user, diem, id_khoa_hoc,time,duration,id_ki_thi) VALUES ({$_SESSION['login']['id']}, $score, $id_khoa_hoc,CURRENT_TIMESTAMP,'$formatted_duration',$id_ki_thi)";
                                mysqli_query($conn, $sql_diem);
                                unset($_SESSION['user_answers']);
                            }
                        }
                    } else {
                        header('location: quan_li_ki_thi.php');
                    }
                } else {
                    header('location: quan_li_ki_thi.php');
                }
                ?>
            </div>

        </div>
        <script>
            var tim;
            var min = <?php echo $thoi_gian ?>;
            var sec = 0;
            var f = new Date();
            var start_time = f.getTime(); // Lưu thời gian bắt đầu làm bài

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
                        return;
                    }
                }
                document.getElementById("showtime").innerHTML = (min < 10 ? "0" : "") + min + " : " + (sec < 10 ? "0" : "") + sec;
                tim = setTimeout(function() {
                    showtime();
                    if (min == 0 && sec == 0) {
                        hetThoiGian();
                    }
                }, 1000);
            }


            function hetThoiGian() {
                submitForm();
                alert('Hết thời gian làm bài. Bài của bạn đã được tự động nộp.');
                document.getElementById("showtime").innerHTML = "00 : 00";
                clearTimeout(tim);
            }

            function submitForm() {
                var end_time = new Date().getTime(); // Lưu thời gian kết thúc làm bài
                var duration = end_time - start_time; // Tính thời gian làm bài
                document.getElementById("duration").value = (duration); // Gán thời gian làm bài vào input hidden
                var submitButton = document.getElementById("submitButton");
                submitButton.click(); // Kích hoạt sự kiện click của nút submit
            }
        </script>
    </main>
    <?php
    include 'footer.php';
    ?>
</body>

</html>