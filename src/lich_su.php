<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử học</title>
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
                <a href="khoa_hoc.php" class="btn_back"><i class="fa fa-chevron-left" aria-hidden="true"></i>Trở lại</a>
            </h3>
        </div>
        <?php ?>
        <div class="">
            <table class="table table-striped">
                <?php
                //admin
                if ($_SESSION['login']['role'] == 'user') {
                    echo " <tr>
                        <th>STT</th>
                        <th>Tên khóa học</th>
                        <th>Điểm</th>
                        <th>Ngay tham gia</th>
                        <th>thoi gian lam bai</th>";
                    $stt = 1;
                    $id_user = $_SESSION['login']['id'];
                    $sql = "SELECT diem_user .*, khoa_hoc.ten_khoa_hoc FROM diem_user JOIN khoa_hoc ON diem_user.id_khoa_hoc = khoa_hoc.id_khoa_hoc WHERE id_user = $id_user ORDER BY id_diem";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $stt . "</td>";
                            echo "<td>" . $row['ten_khoa_hoc'] . "</td>";
                            echo "<td>" . $row['diem'] . "</td>";
                            echo "<td>" . $row['time'] . "</td>";
                            echo "<td>" . $row['duration'] . "</td>";
                            echo "</tr>";
                            $stt++;
                        }
                    } else {
                        echo "<tr>";
                        echo "<td colspan='4' align='center'>Bạn chưa tham gia học</td>";
                        echo "</tr>";
                    }
                } else {
                    if(isset($_GET['id_khoa_hoc'])){
                    echo " <tr>
                        <th>STT</th>
                        <th>Tên khóa học</th>
                        <th>Tài khoản người dùng</th>
                        <th>Tên người dùng</th>
                        <th>Điểm</th>
                        <th>Thời gian tham gia</th>";
                    $stt = 1;
                    $id_user = $_SESSION['login']['id'];
                    $sql = "SELECT diem_user .*, khoa_hoc.ten_khoa_hoc, user.* FROM diem_user JOIN khoa_hoc ON diem_user.id_khoa_hoc = khoa_hoc.id_khoa_hoc JOIN user ON diem_user.id_user = user.id_user where khoa_hoc.id_khoa_hoc=$_GET[id_khoa_hoc] ORDER BY user.username";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $stt . "</td>";
                            echo "<td>" . $row['ten_khoa_hoc'] . "</td>";
                            echo "<td>". $row['username']. "</td>";
                            echo "<td>" . $row['name'] . "</td>";

                            echo "<td>" . $row['diem'] . "</td>";
                            echo "<td>" . $row['time'] . "</td>";
                            echo "</tr>";
                            $stt++;
                        }
                    } else {
                        echo "<tr>";
                        echo "<td colspan='6' align='center'>Chưa có dữ liệu người dùng</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "Vui lòng chọn khóa học";
                }
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