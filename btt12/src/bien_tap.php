<?php
include '../function.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biên tập</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- End bootstrap cdn -->
    <style>
        img {
            max-width: 400px;
        }

        a {
            text-decoration: none;
            color: white;
        }
    </style>
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
            <a href="khoa_hoc.php" class="btn btn-primary">Trở lại</a>

            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                Thêm câu hỏi
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="them_cau_hoi.php?id_khoa_hoc=<?php echo $id_khoa_hoc ?>">Câu hỏi điền</a></li>
                <li><a class="dropdown-item" href="them_cau_hoi_tn.php?id_khoa_hoc=<?php echo $id_khoa_hoc ?>">Câu hỏi trắc nghiệm</a></li>
                <li><a class="dropdown-item" href="them_cau_hoi.php?id_khoa_hoc=<?php echo $id_khoa_hoc ?>">Câu hỏi nối</a></li>
            </ul>

        </div>
        <?php ?>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 0 0 0; ">
            <p class="h3">Danh sách câu hỏi</p>
            <table class="table table-striped">
                <?php
                if ($_SESSION['login']['username'] === "admin") {
                    if (isset($_GET['id_khoa_hoc'])) {
                        if (isset($_POST['update'])) {
                            $id_cau_hoi = $_POST['edit_ch'];
                            $sql = "UPDATE cau_hoi SET trang_thai = 1 WHERE id_cau_hoi = $id_cau_hoi";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                echo "<div class='alert alert-success text-center' role='alert'>Duyệt câu hỏi thành công</div>";
                            } else {
                                echo "<div class='alert alert-danger text-center' role='alert'>Duyệt câu hỏi thất bại</div>";
                            }
                        }
                        if (isset($_POST['delete'])) {
                            $id_cau_hoi = $_POST['edit_ch'];
                            $sql = "DELETE FROM cau_hoi WHERE id_cau_hoi = $id_cau_hoi";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                echo "<div class='alert alert-success text-center' role='alert'>Xóa câu hỏi thành công</div>";
                            } else {
                                echo "<div class='alert alert-danger text-center' role='alert'>Xóa câu hỏi thất bại</div>";
                            }
                        }
                        //admin
                        echo " <tr>
                        <th>STT</th>
                        <th>Tên câu hỏi</th>
                        <th>Loại câu hỏi</th>
                        <th>Đáp án</th>
                        <th>Tác giả</th>
                        <th>Trạng thái</th>
                        <th>Ảnh</th>
                        <th>Thao tác</th>";
                        $stt = 1;
                        $id_khoa_hoc = $_GET['id_khoa_hoc'];
                        $sql = "SELECT cau_hoi.*, user.username AS tac_gia_username FROM cau_hoi JOIN user ON cau_hoi.id_user = user.id_user WHERE cau_hoi.id_khoa_hoc = $id_khoa_hoc";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>{$stt}</td>";
                                echo "<td>{$row['ten_cau_hoi']}</td>";
                                echo "<td>{$row['dang_cau_hoi']}</td>";
                                echo "<td>{$row['dap_an']}</td>";
                                echo "<td>{$row['tac_gia_username']}</td>";
                                if ($row['trang_thai'] == 0) {
                                    echo "<td>Chưa duyệt</td>";
                                } else {
                                    echo "<td>Đã Duyệt</td>";
                                };
                                echo  '<td><img src="../images/quiz/' . $row['file_tai_len'] . '" alt=""></td>';
                                echo '<td>
                            <form action="" method="post">';
                                if ($row['trang_thai'] == 0) {
                                    echo '<input type="submit" class="btn btn-danger" name="delete" value="Xóa">';
                                    echo '<input type="submit" class="btn btn-primary " value="Xem trước">';
                                    echo '<input type="submit" class="btn btn-success " name="update" value="Duyệt">';
                                    echo '<input type="hidden" value="' . $row['id_cau_hoi'] . '" name="edit_ch">';
                                } else {
                                    echo '<input type="submit" class="btn btn-danger" name="delete" value="Xóa">';
                                    echo '<input type="submit" class="btn btn-primary " value="Xem trước">';
                                    echo '<input type="hidden" value="' . $row['id_cau_hoi'] . '" name="edit_ch">';
                                }
                                echo '</form>
                            </td>';
                                echo "</tr>";
                                $stt++;
                            }
                        } else {
                            echo "<tr>";
                            echo "<td align='center' colspan='7'>Không có câu hỏi nào</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo " <tr>
                        <th>STT</th>
                        <th>Tên câu hỏi</th>
                        <th>Loại câu hỏi</th>
                        <th>Đáp án</th>
                        <th>Tác giả</th>
                        <th>Trạng thái</th>
                        <th>Ảnh</th>
                        <th>Thao tác</th>";
                        echo "<tr>";
                        echo "<td align='center' colspan='7'>Không có câu hỏi nào</td>";
                        echo "</tr>";
                    }
                }
                //user
                else {
                    if (isset($_GET['id_khoa_hoc'])) {
                        $id_user = $_SESSION['login']['id'];
                        echo " <tr>
                        <th>STT</th>
                        <th>Tên câu hỏi</th>
                        <th>Loại câu hỏi</th>
                        <th>Đáp án</th>
                        <th>Tác giả</th>
                        <th>Trạng thái</th>
                        <th>Ảnh</th>";
                        $stt = 1;
                        $id_khoa_hoc = $_GET['id_khoa_hoc'];
                        $sql = "SELECT cau_hoi.* FROM cau_hoi JOIN user ON cau_hoi.id_user = user.id_user WHERE cau_hoi.id_khoa_hoc = $id_khoa_hoc AND cau_hoi.id_user = $id_user";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>{$stt}</td>";
                                echo "<td>{$row['ten_cau_hoi']}</td>";
                                echo "<td>{$row['dang_cau_hoi']}</td>";
                                echo "<td>{$row['dap_an']}</td>";
                                if ($row['trang_thai'] == 0) {
                                    echo "<td>Chưa duyệt</td>";
                                } else {
                                    echo "<td>Đã duyệt</td>";
                                }
                                echo '<td><form action="" method="post">';
                                echo '<input type="submit" class="btn btn-primary " value="Xem trước">';
                                echo '</form></td>';
                                echo  '<td><img src="../images/quiz/' . $row['file_tai_len'] . '" alt=""></td>';
                                echo "</tr>";
                                $stt++;
                            }
                        } else {
                            echo "<tr>";
                            echo "<td align='center' colspan='7'>Không có câu hỏi nào</td>";
                            echo "</tr>";
                        }
                    }
                    else {
                        echo " <tr>
                        <th>STT</th>
                        <th>Tên câu hỏi</th>
                        <th>Loại câu hỏi</th>
                        <th>Đáp án</th>
                        <th>Tác giả</th>
                        <th>Trạng thái</th>
                        <th>Ảnh</th>";
                        echo "<tr>";
                        echo "<td align='center' colspan='7'>Không có câu hỏi nào</td>";
                        echo "</tr>";
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