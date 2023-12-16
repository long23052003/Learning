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
            <a href="./quan_li_ki_thi.php" class="btn"><i class="fa fa-chevron-left" aria-hidden="true"></i> Trở lại</a>
            <span class="title_kh" align='center'><b>
                <?php
                if (isset($_GET['id_ki_thi'])) {
                    $id_ki_thi = $_GET['id_ki_thi'];
                    $id_khoa_hoc = $_GET['id_khoa_hoc'];
                    $sql = "SELECT * FROM ki_thi WHERE id_ki_thi = $id_ki_thi";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $gioi_han = $row['gioi_han'];
                    echo $row['ten_ki_thi'];
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
                    $sql_dem_diem="SELECT * FROM diem_user WHERE id_khoa_hoc = $id_khoa_hoc AND diem_user.id_user = $id_user";
                    $result_dem_diem = mysqli_query($conn, $sql_dem_diem);
                    $result_diem = mysqli_query($conn, $sql_diem);
                    $row_diem = mysqli_fetch_assoc($result_diem);
                    $count = mysqli_num_rows($result_dem_diem);
                    echo " <div class='kq-container'>
                    <div class='kq-content'>
                        <h2>Chúc mừng bạn đã hoàn thành bài kiểm tra</h2>
                        <h1>Điểm của bạn: {$row_diem['diem']}</h1>
                        <h3>Thời gian làm bài: {$row_diem['duration']}</h3>
                        <h3>Số lần làm bài: {$count}/{$gioi_han}</h3>
                        <br>
                    </div>
                   
                </div>";
               
                } else {
                    echo "<p>Bạn chưa tham gia thi, vui lòng tham gia thi</p>";
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