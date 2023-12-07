<main>
	<div class="title">
		<h2>Khóa học</h2>
	</div>
	<div class="list">
		<!-- begin khóa học -->
		<div class="card">
			<img src="images/khoahoc.jpg" class="card-img-top" alt="Course Image">
			<div class="card-body">
				<h5 class="card-title">Công nghệ web</h5>
				<a class="btn" href="src/bien_tap.php?id_khoa_hoc=1">Truy cập</a> |
				<?php if (isset($_SESSION['login']['role']) && $_SESSION['login']['role'] == 'user') {
					echo '<a class="btn" href="src/trang_chu.php?id_khoa_hoc=1">Tham gia học</a>';
				} ?>
			</div>
		</div>
		<div class="card">
			<img src="images/khoahoc.jpg" class="card-img-top" alt="Course Image">
			<div class="card-body">
				<h5 class="card-title">Nền tảng phát triển web</h5>
				<a class="btn" href="src/bien_tap.php?id_khoa_hoc=2">Truy cập</a> |
				<?php if (isset($_SESSION['login']['role']) && $_SESSION['login']['role'] == 'user') {
					echo '<a class="btn" href="src/trang_chu.php?id_khoa_hoc=1">Tham gia học</a>';
				} ?>
			</div>
		</div>
		<div class="card">
			<img src="images/khoahoc.jpg" class="card-img-top" alt="Course Image">
			<div class="card-body">
				<h5 class="card-title">Lập trình mạng</h5>
				<a class="btn" href="src/bien_tap.php?id_khoa_hoc=3">Truy cập</a> |
				<?php if (isset($_SESSION['login']['role']) && $_SESSION['login']['role'] == 'user') {
					echo '<a class="btn" href="src/trang_chu.php?id_khoa_hoc=1">Tham gia học</a>';
				} ?>
			</div>
		</div>
		<!-- end khóa học -->
	</div>
</main>