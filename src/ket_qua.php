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
        <div class="score">
            <div>
                <?php
                if($_SESSION['login']['role'] === 'user') {
                if (isset($_GET['id_khoa_hoc'])) {
                    $id_user = $_SESSION['login']['id'];
                    $sql_diem = "SELECT * FROM diem_user JOIN user ON user.id_user = diem_user.id_user WHERE id_khoa_hoc = $id_khoa_hoc AND diem_user.id_user = $id_user ORDER BY diem_user.id_diem DESC LIMIT 1";
                    $result_diem = mysqli_query($conn, $sql_diem);
                    $row_diem = mysqli_fetch_assoc($result_diem);
                    echo " <div class='kq-container'>
                    <div class='kq-content'>
                        <h2>Chúc mừng bạn đã hoàn thành bài kiểm tra</h2>
                        <h1>Điểm của bạn: {$row_diem['diem']}</h1>
                        <h3>Thời gian hoàn thành: {$row_diem['time']}</h3>
                        <br>
                        <a href='./trang_chu.php?id_khoa_hoc=$id_khoa_hoc' class='btn'> Tiếp tục luyện tập</a>'
                    </div>
                   
                </div>";
               
                } else {
                    echo "<p>Vui lòng tham gia khóa học.</p>";
                }
            } else {
                header("Location:khoa_hoc.php");
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