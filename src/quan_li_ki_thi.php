<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kì thi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/khoa_hoc.css">
    <link rel="stylesheet" href="../css/quan_li_ki_thi.css">
    <link rel="stylesheet" href="../css/footer.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        a {
            text-decoration: none;
        }

        section {
            margin-top: 70px;
        }
    </style>
</head>

<body>
    <header>
        <?php
        include '../function.php';
        include "navbar.php";
        ?>
    </header>
    <main>
        <div class="title">
            <h2><?php
            if($_SESSION['login']['role'] == 'admin'){
                echo "Quản lý kì thi";
            } else {
                echo "Kì thi";
            }
            ?></h2>
        </div>
        <div class="list">
            <?php
            if(isset($_POST['delete'])){
                $id_ki_thi = $_POST['delele_thi'];
                $sql = "DELETE FROM ki_thi WHERE id_ki_thi = $id_ki_thi";
                $result = mysqli_query($conn, $sql);
                if($result){
                    echo "<div class='alert-success' role='alert' style='width:100%;'>Xóa kì thi thành công</div>";
                } else {
                    echo "<div class='alert-danger' role='alert' style='width:100%;'>Xóa kì thi thất bại</div>";
                }
            }
            if($_SESSION['login']['role'] == 'admin'){
                echo '<div class="left">
                <form action="" method="post">
                <lable for="id_khoa_hoc">Khóa học:</lable><br>
                <select name="id_khoa_hoc" id="id_khoa_hoc">';
                    $sql = "SELECT * FROM khoa_hoc";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['id_khoa_hoc'] . "'>" . $row['ten_khoa_hoc'] . "</option> <br>";
                        }
                    }
               echo "</select><br>
                <label for='ten_ki_thi'>Tên kì thi:</label><br>
                <input type='text' id='ten_ki_thi' name='ten_ki_thi'><br>
                <label for='so_cau_hoi'>Số câu hỏi:</label><br>
                <input type='number' id='so_cau_hoi' name='so_cau_hoi'><br>
                <label for='thoi_gian'>Thời gian (phút):</label><br>
                <input type='number' id='thoi_gian' name='thoi_gian'><br>
                <label for='gioi_han'>Giới hạn (Số lần thi):</label><br>
                <input type='number' id='gioi_han' name='gioi_han'><br>
                <input type='submit' name='btn_submit' value='Tạo kì thi'>
            </form></div>";
            echo "<div class='table-responsive'> <form action='' method='post'>";
                echo "<table class='table table-striped'>
                    <th>STT</th>
                    <th>Khóa học</th>
                    <th>Tên kì thi</th>
                    <th>Số câu hỏi</th>
                    <th>Thời gian (phút)</th>
                    <th>Giới hạn</th>
                    <th>Thao tác</th>";
                $stt=1;
                $sql = "SELECT * FROM ki_thi JOIN khoa_hoc ON ki_thi.id_khoa_hoc = khoa_hoc.id_khoa_hoc";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $stt . "</td>";
                        echo "<td>" . $row['ten_khoa_hoc'] . "</td>";
                        echo "<td>" . $row['ten_ki_thi'] . "</td>";
                        echo "<td>" . $row['so_cau'] . "</td>";
                        echo "<td>" . $row['time_thi'] . "</td>";
                        echo "<td>" . $row['gioi_han'] . "</td>";
                        echo '<td><input type="submit" class="btn_xoa btn-table" name="delete" value="Xóa">';
                        echo "<a class='btn' href='lich_su_ki_thi.php?id_ki_thi={$row['id_ki_thi']}'>Chi tiết</a></td>";
                        echo '<input type="hidden" class="btn_sua btn-table" name="delele_thi" value="'.$row['id_ki_thi'].'">';
                        echo "</tr>";
                        $stt++;
                    }
                }
                echo "</table></form></div>";
                
            }
            else {
                echo "<form action='' method='post'>";
                echo " <table class='table table-striped'>
                    <th>STT</th>
                    <th>Tên kì thi</th>
                    <th>Số câu hỏi</th>
                    <th>Thời gian (phút)</th>
                    <th>Thao tác</th>";
                $stt=1;
                $sql = "SELECT * FROM ki_thi";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $stt . "</td>";
                        echo "<td>" . $row['ten_ki_thi'] . "</td>";
                        echo "<td>" . $row['so_cau'] . "</td>";
                        echo "<td>" . $row['time_thi'] . "</td>";
                        echo "<td><a class='btn' href='ki_thi.php?id_ki_thi={$row['id_ki_thi']}&id_khoa_hoc={$row['id_khoa_hoc']}'>Thi ngay</a>
                        
                        <a class='btn' href='lich_su_ki_thi.php?id_ki_thi={$row['id_ki_thi']}'>Lịch sử</a>
                        </td>";
                        
                        echo "</tr>";
                        $stt++;
                        
                    }
                }
                echo "</table></form>";
            }
            ?>
        </div>
        <?php
        if (isset($_POST['btn_submit'])) {
            if (empty($_POST['id_khoa_hoc']) || empty($_POST['ten_ki_thi']) || empty($_POST['so_cau_hoi']) || empty($_POST['thoi_gian'])) {
                echo "<div class='alert-danger' role='alert' style='width:100%;'>Vui lòng nhập đầy đủ thông tin</div>";
            } else {
                $id_khoa_hoc = $_POST['id_khoa_hoc'];
                $ten_ki_thi = $_POST['ten_ki_thi'];
                $so_cau_hoi = $_POST['so_cau_hoi'];
                $thoi_gian = $_POST['thoi_gian'];
                $gioi_han = $_POST['gioi_han'];
                $sql = "INSERT INTO ki_thi (id_khoa_hoc, ten_ki_thi, so_cau, time_thi, gioi_han) VALUES ($id_khoa_hoc, '$ten_ki_thi', $so_cau_hoi, $thoi_gian, $gioi_han)";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: quan_li_ki_thi.php");
                } else {
                    echo "<div class='alert-danger' role='alert' style='width:100%;'>Tạo kì thi that bai</div>";
                }
            }
        }
       
        ?>
    </main>
</body>
<footer>
    <?php
    include "../src/footer.php";
    ?>
</footer>

</html>