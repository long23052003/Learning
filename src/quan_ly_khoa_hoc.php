<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/khoa_hoc.css">
    <link rel="stylesheet" href="../css/bien_tap.css">
    <link rel="stylesheet" href="../css/footer.css">
    <title>Document</title>
</head>
<body>
    <?php include '../function.php';
    include('navbar.php'); ?>
    <main>
        <div class="title">
            <h2>Khóa học</h2>
        </div>
        <div class="list">
            <!-- begin khóa học -->
            <div class="table">
                <table>
                    <th>STT</th>
                    <th>Tên khoa học</th>
                    <th>Mô tả </th>
                    <th>Thao tác</th>

                    <?php
                    $sql = "SELECT * FROM khoa_hoc";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id_khoa_hoc']}</td>";
                        echo "<td>{$row['ten_khoa_hoc']}</td>";
                        echo "<td>{$row['mo_ta']}</td>";
                        echo "<td><button class='btn btn-table'><a href='bien_tap.php?id_khoa_hoc={$row['id_khoa_hoc']}'>Xem</a></button>";
                        echo '<input type="submit" class="btn_xoa btn-table" name="delete" value="Xóa"></td>';
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>    

    </main>
    <?php include 'footer.php'; ?>
</body>
</html>