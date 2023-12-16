<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử thi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/bien_tap.css">
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
                <a href="quan_li_ki_thi.php" class="btn_back"><i class="fa fa-chevron-left" aria-hidden="true"></i>Trở lại</a>
            </h3>
        </div>
        <?php ?>
        <div class="">
            <table class="table table-striped">
                <?php
                //admin
                if (isset($_GET['id_ki_thi'])) {
                    if ($_SESSION['login']['role'] == 'user') {
                        echo " <tr>
                        <th>Lần</th>
                        <th>Tên khóa học</th>
                        <th>Tên kì thi </th>
                        <th>Điểm</th>
                        <th>Ngày làm bài</th>
                        <th>Thời gian làm bài</th>";
                        $stt = 1;
                        $id_user = $_SESSION['login']['id'];
                        $sql = "SELECT diem_user .*, khoa_hoc.ten_khoa_hoc,ki_thi.* FROM diem_user JOIN khoa_hoc ON diem_user.id_khoa_hoc = khoa_hoc.id_khoa_hoc JOIN ki_thi ON diem_user.id_ki_thi=diem_user.id_ki_thi WHERE diem_user.id_ki_thi={$_GET['id_ki_thi']} AND id_user = $id_user ORDER BY id_diem";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $stt . "</td>";
                                echo "<td>" . $row['ten_khoa_hoc'] . "</td>";
                                echo "<td>" . $row["ten_ki_thi"] . "</td>";
                                echo "<td>" . $row['diem'] . "</td>";
                                echo "<td>" . $row['time'] . "</td>";
                                echo "<td>" . $row['duration'] . "</td>";
                                echo "</tr>";
                                $stt++;
                            }
                        } else {
                            echo "<tr>";
                            echo "<td colspan='6' align='center'>Bạn chưa tham gia kì thi này</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo " <tr>
                        <th>STT</th>
                        <th>Tên khóa học</th>
                        <th>Tên kì thi </th>
                        <th>Tài khoản người dùng</th>
                        <th>Tên người dùng</th>
                        <th>Điểm</th>
                        <th>Thời gian tham gia</th>
                        <th>Thời gian hoàn thành (phút)</th>";
                        $stt = 1;
                        $id_user = $_SESSION['login']['id'];
                        $sql = "SELECT diem_user .*, khoa_hoc.ten_khoa_hoc, user.*,ki_thi.* FROM diem_user JOIN khoa_hoc ON diem_user.id_khoa_hoc = khoa_hoc.id_khoa_hoc JOIN user ON diem_user.id_user = user.id_user JOIN ki_thi ON ki_thi.id_ki_thi=diem_user.id_ki_thi WHERE diem_user.id_ki_thi={$_GET['id_ki_thi']} ORDER BY user.username";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $stt . "</td>";

                                echo "<td>" . $row['ten_khoa_hoc'] . "</td>";
                                echo "<td>" . $row["ten_ki_thi"] . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['diem'] . "</td>";
                                echo "<td>" . $row['time'] . "</td>";
                                echo "<td>" . $row['duration'] . "</td>";
                                echo "</tr>";
                                $stt++;
                            }
                        } else {
                            echo "<tr>";
                            echo "<td colspan='8' align='center'>Chưa có dữ liệu người dùng</td>";
                            echo "</tr>";
                        }
                    }
                } else {
                    echo "<div>Vui lòng chọn kì thi</div>";
                }
                ?>
            </table>

        </div>
    </main>
    <?php
    include 'footer.php';
    ?>
</body>

</html>