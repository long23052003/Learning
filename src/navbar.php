<? include '../function.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
<style>
    .navbar {
      display: flex;
      padding: 10px;
    }

    
    .logout:active {
      background-color: red !important; /* Change to your desired color */
    }
    .logout:hover {
      background-color: red !important;
      color :aliceblue !important; /* Change to your desired color */
    }
  </style>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="menu container-fluid">
    <a class="navbar-brand" href="khoa_hoc.php">ProjectPHP K71</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
            if (isLogin() == false) {
              header('Location: dang_nhap.php');
            } else {
              echo $_SESSION['login']['username'];
            }
            ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="trang_ca_nhan.php">Trang cá nhân</a></li>
            <li><a class="dropdown-item" href="doi_mk.php">Đổi mật khẩu</a></li>
            <li><a class="logout dropdown-item" href="dang_xuat.php" data-mdb-ripple-init data-mdb-ripple-color="light">Đăng xuất</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>