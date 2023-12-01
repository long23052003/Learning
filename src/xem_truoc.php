<?php
include '../function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem trước</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/xem_truoc.css">
    <!-- End bootstrap cdn -->
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
        <div style="margin: 20px 30%;">
            <div class="form-group">
                <label for="name_quiz">
                    <h4>Câu hỏi: <?php
                                    if (isset($_GET['id_cau_hoi'])) {
                                        $id_cau_hoi = $_GET['id_cau_hoi'];
                                        $sql = "SELECT * FROM cau_hoi WHERE id_cau_hoi = $id_cau_hoi";
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        echo $row['ten_cau_hoi'];
                                    } else {
                                        echo "";
                                    }
                                    ?></h4>
                </label>
            </div>
            <div class="form-group">
                <?php
                if (isset($_GET['id_cau_hoi'])) {
                    $id_cau_hoi = $_GET['id_cau_hoi'];
                    $sql = "SELECT * FROM cau_hoi WHERE id_cau_hoi = $id_cau_hoi";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo  '<img class="img-fluid" src="../images/quiz/' . $row['file_tai_len'] . '" alt="">';
                }
                ?>
            </div>
            <div style="margin: 20px 0 0 0;" class="input-group mb-3">
                <?php
                if (isset($_GET['id_cau_hoi'])) {
                    $id_cau_hoi = $_GET['id_cau_hoi'];
                    $sql = "SELECT * FROM cau_hoi WHERE id_cau_hoi = $id_cau_hoi";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['dang_cau_hoi'] === 'Điền') {
                                echo '<div class="input-group mb-3">
                                <lable class="input-group-text" for="inputGroupSelect01">ĐA</lable>
                                <input name="dap_an" type="text" class="form-control" value="' . $row['dap_an'] . ' " readonly>
                                </div>';
                            } else if ($row['dang_cau_hoi'] === 'Trắc nghiệm') {
                                $answers = explode(",", $row['dap_an']);
                                $answers = array_map(function ($answers) {
                                    return str_replace("(Đúng)", "", $answers);
                                }, $answers);
                                foreach ($answers as $answer) {
                                    echo '<div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">';
                                    echo '<input class"form-check-input" type="radio"' . ($answer === $row['dap_an_dung'] ? 'checked' : '') . ' >';
                                    echo '</div>
                                    </div>';
                                    echo '<input type="text" class="form-control" aria-label="Text input with radio button" value="' . $answer . '" readonly><br>';
                                    echo '</div>';
                                }
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