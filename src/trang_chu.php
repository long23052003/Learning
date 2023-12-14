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

<body onload="starttime() ">
    <?php
    include '../function.php';
    include 'navbar.php';
    ?>
    <main>
        <div id="action">
        <p class="h3">
            <a href="./khoa_hoc.php" class="btn"><i class="fa fa-chevron-left" aria-hidden="true"></i> Trở lại</a>
            <span class="title_kh"><b>Khóa học
                <?php
                if (isset($_GET['id_khoa_hoc'])) {
                    $id_khoa_hoc = $_GET['id_khoa_hoc'];
                    $sql = "SELECT * FROM khoa_hoc WHERE id_khoa_hoc = $id_khoa_hoc";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['ten_khoa_hoc'];
                }
                ?></b></span>
            </p>
        </div>
        <div class="trang_chu">
            <div>
                <div id="showtime"></div>
                <div id="clear-float"></div>
            </div>
            <div>
                <?php
                if(isset($_POST['btn_nop_bai'])){
                    header('location: ket_qua.php?id_khoa_hoc=' . $id_khoa_hoc . '');
                }
                if (isset($_GET['id_khoa_hoc']) && $_GET['id_khoa_hoc'] != '') {
                    if ($_SESSION['login']['role'] === 'user') {
                        // Truy vấn để lấy danh sách câu hỏi
                        $Stt = 1;
                        $query = "SELECT * FROM cau_hoi WHERE id_khoa_hoc = $id_khoa_hoc AND trang_thai=1 and id_user != {$_SESSION['login']['id']} ORDER BY RAND() LIMIT 10";
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
                            echo '<hr /><input type="submit" name="btn_nop_bai" class="btn submit" id="submitButton" value="Nộp bài"></form>';
                        } else {
                            echo '<p>Không có câu hỏi nào.</p>';
                        }
                        if (isset($_POST['btn_nop_bai'])) {
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

                                // echo $score;
                                // echo '<pre>';
                                // print_r(($_SESSION['user_answers']));
                                // echo '</pre>';
                                $sql_diem = "INSERT INTO diem_user (id_user, diem, id_khoa_hoc,time) VALUES ({$_SESSION['login']['id']}, $score, $id_khoa_hoc,CURRENT_TIMESTAMP)";
                                mysqli_query($conn, $sql_diem);
                                unset($_SESSION['user_answers']);
                            }
                        }
                    } else {
                        header('location: khoa_hoc.php');
                    }
                } else {
                    header('location: khoa_hoc.php');
                }
                ?>
            </div>

        </div>
        <script>
            var tim;
            <?php
            echo 'var min = 1 * ' . mysqli_num_rows($result) . ';';
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