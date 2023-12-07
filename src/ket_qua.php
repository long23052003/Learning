<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/score.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>
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
        <div class="score">
            <div>
                <?php
                // Truy vấn để lấy danh sách câu hỏi
                $cau_dung = 0;
                $query = "SELECT * FROM cau_hoi WHERE id_khoa_hoc = $id_khoa_hoc AND trang_thai=1";
                $result = mysqli_query($conn, $query);
                $number_ques = mysqli_num_rows($result);
                // Kiểm tra xem có câu hỏi nào hay không
                if ($number_ques > 0) {
                    $dad = array();
                    $list = array();
                    // Lọc các loại câu để tạo danh sách đáp án đúng
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['dang_cau_hoi'] === 'Điền' || $row['dang_cau_hoi'] === 'Trắc nghiệm') {
                            array_push($dad, ['id_cau_hoi' => $row['id_cau_hoi'], 'dad' => $row['dap_an_dung']]);
                        } else if ($row['dang_cau_hoi'] === 'Trắc nghiệm nhiều đáp án') {
                            $answers = explode(",", $row['dap_an_dung']);
                            array_push($dad, ['id_cau_hoi' => $row['id_cau_hoi'], 'dad' => $answers]);
                        } else {
                            $answers = explode(",", $row['dap_an_dung']);
                            $answers = array_map(function ($answer) {
                                $exp = explode("-", $answer);
                                return ["cau_hoi" => $exp[0], "dap_an" => $exp[1]];
                            }, $answers);
                            $list = $answers;
                            $questions = explode(",", $row['ten_cau_hoi']);
                            array_push($dad, ['id_cau_hoi' => $row['id_cau_hoi'], 'dad' => [$questions, $answers]]);
                        }
                    }
                    if (isset($_POST['btn_nop_bai'])) {
                        if (isset($_POST['dap_an'])) {
                            foreach ($dad as $item) {
                                if (isset($_POST['dap_an'][$item['id_cau_hoi']])) {
                                    $check = false;
                                    if (!is_array($_POST['dap_an'][$item['id_cau_hoi']])) {
                                        // var_dump( $_POST['dap_an'][$item['id_cau_hoi']] == $item['dad']);
                                        $check =strcmp($_POST['dap_an'][$item['id_cau_hoi']],$item['dad']) ==0 ?true:false;
                                    } else {
                                        $check = false;
                                        foreach ($_POST['dap_an'][$item['id_cau_hoi']] as $index => $key) {
                                            // Kiểm tra xem giá trị lưu có là số không, kết quả của câu nối là số (dưới 10), của câu nhiều đáp án là chữ hoặc số ( trên 10)
                                            if (is_numeric($key)) {
                                                if (strcmp($item['dad'][0][$key - 1],$list[$key - 1]['cau_hoi']) == 0) {
                                                    $check = true;
                                                }
                                            } else {
                                                // Tìm kiếm giá trị của câu nhiều đáp án có trong mảng các đáp án đúng không
                                                $check = in_array($key,$item['dad']);
                                            }
                                        }
                                    }
                                    $cau_dung += $check?1:0;
                                }
                            }
                        }
                    }
                    $score = $cau_dung/$number_ques*100;
                    echo <<<EOD
                        <div class="kq-container">
                            <div class="kq-content">
                                <h1>{$score}</h1>
                                <h3>Số câu đúng {$cau_dung}/{$number_ques}</h3>
                            </div>
                        </div>
                    EOD;
                    
                } else {
                    echo '<p>Lỗi hệ thống.</p>';
                }
                ?>
            </div>
        </div>
    </main>
    <?php
    include 'footer.php';
    ?>
</body>

</html>