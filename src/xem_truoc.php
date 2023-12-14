<?php
include '../function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem trước</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/xem_truoc.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>
    <?php
    include 'navbar.php';
    ?>
    <main>
        <div id="action">
            <p class="h3">
                <a href="./bien_tap.php?id_khoa_hoc=<?php if (isset($_GET['id_khoa_hoc'])) {
                                                        echo $_GET['id_khoa_hoc']; 
                                                    } else {
                                                        header('Location:bien_tap.php');
                                                    }
                                                    ?>" class="btn"><i class="fa fa-chevron-left" aria-hidden="true"></i> Trở lại</a>
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
        <div class="container">
            <div class="form-group">
                <label for="name_quiz" class="ques">
                    <?php
                    if (isset($_GET['id_cau_hoi'])) {
                        $id_cau_hoi = $_GET['id_cau_hoi'];
                        $sql = "SELECT * FROM cau_hoi WHERE id_cau_hoi = $id_cau_hoi";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $questions = explode(';', ($row['ten_cau_hoi']));
                        if (sizeof($questions) < 2) {
                            if ($row['dang_cau_hoi'] === 'Điền') {
                                echo '<h3>Câu hỏi: Điền vào chỗ trống "' . htmlspecialchars($questions[0]) . '"</h3>';
                            } else if ($row['dang_cau_hoi'] === 'Nối câu') {
                                echo '<h3>Câu hỏi: Nối 2 cấu sau để tạo đáp án đúng</h3>';
                            } else {
                                echo '<h3>Câu hỏi: ' . htmlspecialchars($questions[0]) . '</h3>';
                            }
                        }
                    } else {
                        echo "";
                    }
                    ?>
                </label>
            </div>
            <div class="form-group">
                <?php
                if (isset($_GET['id_cau_hoi'])) {
                    $id_cau_hoi = $_GET['id_cau_hoi'];
                    $sql = "SELECT * FROM cau_hoi WHERE id_cau_hoi = $id_cau_hoi";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo  '<img class="img-fluid" src="../images/quiz/' . htmlspecialchars($row['file_tai_len']) . '" alt="">';
                }
                ?>
            </div>
            <div class="answer">
                <?php
                if (isset($_GET['id_cau_hoi'])) {
                    $id_cau_hoi = $_GET['id_cau_hoi'];
                    $sql = "SELECT * FROM cau_hoi WHERE id_cau_hoi = $id_cau_hoi";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['dang_cau_hoi'] === 'Điền') {
                                echo '<div class="">
                                <div class="form">
                                <input name="dap_an" type="text" class="form-control" value="' . $row['dap_an'] . ' " readonly >
                                </div></div>';
                            } else if ($row['dang_cau_hoi'] === 'Trắc nghiệm') {
                                $answers = explode(";", ($row['dap_an']));
                                $answers = array_map(function ($answers) {
                                    return str_replace("(Đúng)", "", $answers);
                                }, $answers);
                                foreach ($answers as $answer) {
                                    echo '<div class="form">
                                    <div class="">';
                                    echo '<input class"form-check-input" type="radio"' . ($answer === ($row['dap_an_dung']) ? 'checked' : '') . ' disabled>';
                                    echo '</div>';
                                    echo '<input type="text" class="form-control" value="' . htmlspecialchars($answer) . '" readonly><br>';
                                    echo '</div>';
                                }
                            } else if ($row['dang_cau_hoi'] === 'Trắc nghiệm nhiều đáp án') {
                                $answers = explode(";", ($row['dap_an']));
                                $answers = array_map(function ($answer) {
                                    return str_replace("(Đúng)", "", $answer);
                                }, $answers);
                                $correctAnswers = explode(";", ($row['dap_an_dung']));
                                foreach ($answers as $answer) {
                                    echo '<div class="form">';
                                    echo '<div class="form-check">';
                                    echo '<input class="form-check-input" type="checkbox" ' . (in_array($answer, $correctAnswers) ? 'checked' : '') . ' disabled>';
                                    echo '</div>';
                                    echo '<input type="text" class="form-control" value="' . htmlspecialchars($answer) . '" readonly><br>';
                                    echo '</div>';
                                }
                            } else {
                                $correctAnswers =  explode(";", (($row['dap_an_dung'])));
                                echo "<table>";
                                echo '
                                    <tr>
                                        <th>Câu hỏi</th>
                                        <th>Đáp án</th>
                                    </tr>
                                ';
                                foreach ($correctAnswers as $kq) {
                                    $arr = explode("-", $kq);
                                    echo '<tr>';
                                    echo '<td>' . (isset($arr[0]) ? htmlspecialchars($arr[0]) : '') . '</td>';
                                    echo '<td>' . (isset($arr[1]) ? htmlspecialchars($arr[1]) : '') . '</td>';
                                    echo '</tr>';
                                }
                                echo "</table>";
                            }
                        }
                    }
                }
                ?>
            </div>
    </main>
    <?php
    include 'footer.php';
    ?>
</body>

</html>