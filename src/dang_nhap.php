<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đăng nhập</title>
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/dang_ki.css">
</head>

<body>
	<div class="header">
		<h5>Chào mừng bạn đến với ELearning-k71!</h5>
	</div>
	<form method="POST" class="login-form">
		<h2 id="title">Đăng nhập</h2>
		<?php 
			include '../function.php';
			if (isset($_POST['submitLogin'])) {
				if (empty($_POST['username'])) {
					echo '<div class="alert-warning" role="alert">Vui lòng nhập tên đăng nhập!</div>';
				} else if (empty($_POST['password'])) {
					echo '<div class="alert-warning" role="alert">Vui lòng nhập mật khẩu!</div>';
				} else{
					if(checkLogin($_POST['username'],$_POST['password'])){
						header('Location: ../index.php');
					}else{
						echo '<div class="alert-warning" role="alert">Tên đăng nhập hoặc mật khẩu không đúng!</div>';
					}
				}
			}
		?>
		<div class="form-input">
			<label for="username" class="form-label">Tên đăng nhập</label>
			<input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập">
		</div>
		<div class="form-input">
			<label for="inputPassword" class="col-sm-2 col-form-label">Mật khẩu</label>
			<input type="password" class="form-control" id="inputPassword" placeholder="Nhập mật khẩu" name="password">
		</div>
		<input type="submit" class="btn-submit" name="submitLogin" value="Đăng nhập">
		<button class="btn-redirect"><a href="dang_ki.php">Đăng kí</a></button>

	</form>
</body>

</html>