<!DOCTYPE html>
<html lang="en">
<head>
</head>
<nav class="navbar">
  <div class="navbar-list-brand">
    <div class="brand">
            <a class="navbar-brand-logo" href="khoa_hoc.php">ELearning-K71</a>
            <div class="brand-items">
              <a class="" href="khoa_hoc.php"><i class="fa fa-book" aria-hidden="true"></i> Khóa học</a>
              <a href="quan_li_ki_thi.php"><i class="fa fa-server" aria-hidden="true"></i> Kỳ thi</a>
            </div>
    </div>
    <div class="navbar-sub">
      <p class="navbar-toggler">
        <?php
        if (isLogin() == false) {
          header('Location: dang_nhap.php');
        } else {
          $sql="SELECT * FROM user WHERE username = '{$_SESSION['login']['username']}'";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);
          echo '<img id="avt" src="../images/avt/'.$row['img_avt'].'"/> '.$_SESSION['login']['username'];
          }
        ?>
        <i class="fa fa-sort-desc" aria-hidden="true"></i>
      </p>
      <div class="subnav-content">
            <?php if (isLogin() == true && $_SESSION['login']['role'] == 'admin' ) {
              echo '<a class="sub-item" href="khoa_hoc.php">Quản lý khóa học</a>';
              } else {
                echo '<a class="sub-item" href="khoa_hoc.php">Khóa học của tôi</a>';
                echo '<a class="sub-item" href="lich_su.php">Lịch sử học</a>';
              }
               ?>
            <a class="sub-item" href="trang_ca_nhan.php">Trang cá nhân</a>
            <a class="sub-item" href="doi_mk.php">Đổi mật khẩu</a>
            <a class="logout sub-item" href="dang_xuat.php">Đăng xuất</a>
      </div>
    </div>
  </div>
</nav>