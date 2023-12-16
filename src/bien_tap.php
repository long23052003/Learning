<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biên tập</title>
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
            <p class="h3">

                <a href="./khoa_hoc.php" class="btn"><i class="fa fa-chevron-left" aria-hidden="true"></i> Trở lại</a>
                <span class="title_kh"><b>Khóa học
                        <?php
                        if (isset($_GET['id_khoa_hoc']) && $_GET['id_khoa_hoc'] != '') {
                            $id_khoa_hoc = $_GET['id_khoa_hoc'];
                            $sql = "SELECT * FROM khoa_hoc WHERE id_khoa_hoc = $id_khoa_hoc";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            echo $row['ten_khoa_hoc'];
                        }
                        ?></b></span>
            </p>
            <div class="btn-top">
                <div class="sub-menu">
                    <p class="dropdown-toggle" data-bs-toggle="dropdown">
                        Thêm câu hỏi <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    </p>
                    <div class="ques-menu">
                        <a class="dropdown-item" href="them_cau_hoi.php?id_khoa_hoc=<?php echo $id_khoa_hoc; ?>">Câu hỏi điền</a>
                        <a class="dropdown-item" href="them_cau_hoi_tn.php?id_khoa_hoc=<?php echo $id_khoa_hoc; ?>">Câu hỏi trắc nghiệm 1 đáp án</a>
                        <a class="dropdown-item" href="them_cau_noi.php?id_khoa_hoc=<?php echo $id_khoa_hoc; ?>">Câu hỏi nối</a>
                        <a class="dropdown-item" href="them_cau_nhieu_dap_an.php?id_khoa_hoc=<?php echo $id_khoa_hoc; ?>">Câu hỏi với trắc nghiệm nhiều đáp án</a>
                    </div>
                </div>
            </div>
        </div>
        <?php ?>
        <div class="">
            <table class="table table-striped">
                <?php
                if ($_SESSION['login']['role'] == 'admin') {
                    if (isset($_GET['id_khoa_hoc']) && $_GET['id_khoa_hoc'] != '') {
                        if (isset($_POST['update'])) {
                            $id_cau_hoi = $_POST['edit_ch'];
                            $sql = "UPDATE cau_hoi SET trang_thai = 1 WHERE id_cau_hoi = $id_cau_hoi";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                echo "<div class='alert-success' role='alert' style='width:100%;'>Duyệt câu hỏi thành công</div>";
                            } else {
                                echo "<div class='alert-danger' role='alert'style='width:100%;'>Duyệt câu hỏi thất bại</div>";
                            }
                        }

                        if (isset($_POST['delete'])) {
                            $id_cau_hoi = $_POST['edit_ch'];
                            $sql_delete_cau_hoi = "DELETE FROM cau_hoi WHERE id_cau_hoi = $id_cau_hoi";
                            $result_delete_cau_hoi = mysqli_query($conn, $sql_delete_cau_hoi);

                            // Check if deletion from dap_an was successful

                            // Now, you can safely delete the row from cau_hoi table


                            if ($result_delete_cau_hoi) {
                                echo "<div class='alert-success' role='alert' style='width:100%;'>Xóa câu hỏi thành công</div>";
                            } else {
                                echo "<div class='alert-danger' role='alert' style='width:100%;'>Xóa câu hỏi thất bại</div>";
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
                        <th>Thời gian thêm</th>
                        <th>Thao tác</th>";
                        $stt = 1;
                        $id_khoa_hoc = $_GET['id_khoa_hoc'];
                        $sql = "SELECT cau_hoi.*, user.username AS tac_gia_username FROM cau_hoi JOIN user ON cau_hoi.id_user = user.id_user WHERE cau_hoi.id_khoa_hoc = $id_khoa_hoc";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>{$stt}</td>";
                                $questions = explode(";", ($row['ten_cau_hoi']));
                                echo "<td>";
                                echo "<ul>";
                                foreach ($questions as $question) {
                                    echo "<li>" . htmlspecialchars($question) . "</li>";
                                }
                                echo "</ul>";
                                echo "</td>";
                                echo "<td>{$row['dang_cau_hoi']}</td>";
                                echo "<td>";
                                $answers = explode(";", ($row['dap_an']));
                                echo "<ul>";
                                foreach ($answers as $answer) {
                                    echo "<li>" . htmlspecialchars($answer) . "</li>";
                                }
                                echo "</ul>";
                                echo "</td>";
                                echo "<td>{$row['tac_gia_username']}</td>";
                                if ($row['trang_thai'] == 0) {
                                    echo "<td>Chưa duyệt</td>";
                                } else {
                                    echo "<td>Đã Duyệt</td>";
                                };
                                echo  '<td><img width="200px" src="../images/quiz/' . $row['file_tai_len'] . '" alt=""></td>';
                                echo '<td>' . $row['time_add'] . '</td>';
                                echo '<td>
                            <form action="" method="post">';
                                if ($row['trang_thai'] == 0) {
                                    echo '<input type="submit" class="btn_xoa btn-table" name="delete" value="Xóa">';
                                    echo '<button class="btn btn-table"><a href="xem_truoc.php?id_khoa_hoc=' . $id_khoa_hoc . '&id_cau_hoi=' . $row['id_cau_hoi'] . '">Xem Trước</a></button>';
                                    echo '<input type="submit" class="btn_duyet btn-table" name="update" value="Duyệt">';
                                    echo '<input type="hidden" value="' . $row['id_cau_hoi'] . '" name="edit_ch">';
                                } else {
                                    echo '<input type="submit" class="btn_xoa btn-table" name="delete" value="Xóa">';
                                    echo '<button class="btn btn-table"><a href="xem_truoc.php?id_khoa_hoc=' . $id_khoa_hoc . '&id_cau_hoi=' . $row['id_cau_hoi'] . '">Xem Trước</a></button>';
                                    echo '<input type="hidden" value="' . $row['id_cau_hoi'] . '" name="edit_ch">';
                                }
                                echo '</form>
                            </td>';
                                echo "</tr>";
                                $stt++;
                            }
                        } else {
                            echo "<tr>";
                            echo "<td align='center' colspan='8'>Không có câu hỏi nào</td>";
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
                        <th>Thời gian thêm</th>
                        <th>Thao tác</th>";
                        echo "<tr>";
                        echo "<td align='center' colspan='8'>Không có câu hỏi nào</td>";
                        echo "</tr>";
                    }
                }
                //user
                else {
                    if (isset($_GET['id_khoa_hoc']) && $_GET['id_khoa_hoc'] != '') {
                        $id_user = $_SESSION['login']['id'];
                        echo " <tr>
                        <th>STT</th>
                        <th>Tên câu hỏi</th>
                        <th>Loại câu hỏi</th>
                        <th>Đáp án</th>
                        <th>Tác giả</th>
                        <th>Trạng thái</th>
                        <th>Ảnh</th>
                        <th>Thời gian thêm</th>";
                        $stt = 1;
                        $id_khoa_hoc = $_GET['id_khoa_hoc'];
                        $sql = "SELECT cau_hoi.* FROM cau_hoi JOIN user ON cau_hoi.id_user = user.id_user WHERE cau_hoi.id_khoa_hoc = $id_khoa_hoc AND cau_hoi.id_user = $id_user";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>{$stt}</td>";
                                $questions = explode(";", ($row['ten_cau_hoi']));
                                echo "<td>";
                                echo "<ul>";
                                foreach ($questions as $question) {
                                    echo "<li>" . htmlspecialchars($question) . "</li>";
                                }
                                echo "</ul>";
                                echo "</td>";
                                echo "<td>{$row['dang_cau_hoi']}</td>";
                                echo "<td>";
                                echo "<ul>";
                                $answers = explode(";", ($row['dap_an']));
                                foreach ($answers as $answer) {
                                    echo "<li>" . htmlspecialchars($answer) . "</li>";
                                }
                                echo "</ul>";
                                echo "</td>";
                                if ($row['trang_thai'] == 0) {
                                    echo "<td>Chưa duyệt</td>";
                                } else {
                                    echo "<td>Đã duyệt</td>";
                                }
                                echo '<td><form action="" method="post">';
                                echo '<button class="btn btn-table"><a href="xem_truoc.php?id_khoa_hoc=' . $id_khoa_hoc . '&id_cau_hoi=' . $row['id_cau_hoi'] . '">Xem Trước</a></button>';
                                echo '</form></td>';
                                echo  '<td><img src="../images/quiz/' . $row['file_tai_len'] . '" width="200px" alt=""></td>';
                                echo '<td>' . $row['time_add'] . '</td>';
                                echo "</tr>";
                                $stt++;
                            }
                        } else {
                            echo "<tr>";
                            echo "<td align='center' colspan='8'>Không có câu hỏi nào</td>";
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
                        <th>Thời gian thêm</th>";
                        
                        echo "<tr>";
                        echo "<td align='center' colspan='8'>Không có câu hỏi nào</td>";
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