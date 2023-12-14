<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khóa học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/khoa_hoc.css">
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
		<h2>Khóa học</h2>
	</div>
	<div class="list">
		<!-- begin khóa học -->
		<div class="card">
			<img src="../images/khoahoc.jpg" class="card-img-top" alt="Course Image">
			<div class="card-body">
				<h5 class="card-title">Công nghệ web</h5>
				<a class="btn" href="bien_tap.php?id_khoa_hoc=1">Truy cập</a> 
				<?php if (isset($_SESSION['login']['role']) && $_SESSION['login']['role'] == 'user') {
					echo '<a class="btn" href="trang_chu.php?id_khoa_hoc=1">Tham gia học</a>';
				} else {
					echo '<a class="btn" href="lich_su.php?id_khoa_hoc=1">Chi tiết</a>';
				}
				?>
			</div>
		</div>
		<div class="card">
			<img src="../images/khoahoc.jpg" class="card-img-top" alt="Course Image">
			<div class="card-body">
				<h5 class="card-title">Nền tảng phát triển web</h5>
				<a class="btn" href="bien_tap.php?id_khoa_hoc=2">Truy cập</a>
				<?php if (isset($_SESSION['login']['role']) && $_SESSION['login']['role'] == 'user') {
					echo '<a class="btn" href="trang_chu.php?id_khoa_hoc=2">Tham gia học</a>';
				}  else {
					echo '<a class="btn" href="lich_su.php?id_khoa_hoc=2">Chi tiết</a>';
				}
				?>
			</div>
		</div>
		<div class="card">
			<img src="../images/khoahoc.jpg" class="card-img-top" alt="Course Image">
			<div class="card-body">
				<h5 class="card-title">Lập trình mạng</h5>
				<a class="btn" href="bien_tap.php?id_khoa_hoc=3">Truy cập</a> 
				<?php if (isset($_SESSION['login']['role']) && $_SESSION['login']['role'] == 'user') {
					echo '<a class="btn" href="trang_chu.php?id_khoa_hoc=3">Tham gia học</a>';
				} else {
					echo '<a class="btn" href="lich_su.php?id_khoa_hoc=3">Chi tiết</a>';
				}
				?>
			</div>
		</div>
		<!-- end khóa học -->
	</div>
</main>
</body>
<footer>
    <?php
    include "../src/footer.php";
    ?>
</footer>

</html>