<nav class="navbar">
  <div class="navbar-list-brand">
    <div class="brand">
      <?php
          $path = $_SERVER['PHP_SELF'];
          $hrefi = strpos($path, 'src') !== false ? '../' : '';
          echo <<<EOD
            <a class="navbar-brand-logo" href="{$hrefi}index.php">ELearning-K71</a>
            <div class="brand-items">
              <a class="" href="{$hrefi}index.php"><i class="fa fa-book" aria-hidden="true"></i> Khóa học</a>
              <a href=""><i class="fa fa-server" aria-hidden="true"></i> Kỳ thi</a>
            </div>
          EOD;
        ?>
    </div>
    <div class="navbar-sub">
      <p class="navbar-toggler">
        <?php
        if (isLogin() == false) {
          header('Location: ./src/dang_nhap.php');
          exit;
        } else {
          echo '<img id="avt" src="'.(strpos($_SERVER['PHP_SELF'], 'src') !== false ? '../' : '').'images/'.$_SESSION['login']['img_avt'].'"/> '.$_SESSION['login']['username'];
        }
        ?>
        <i class="fa fa-sort-desc" aria-hidden="true"></i>
      </p>
      <div class="subnav-content">
        <?php
          $path = $_SERVER['PHP_SELF'];
          //Chuyen huong toi index.php
          $hrefi = strpos($path, 'src') !== false ? '../' : '';
          //Chuyển hướng từ các tệp trong src
          $hrefs = strpos($path, 'src') !== false ? '' : './src/';
          echo <<<EOD
            <a class="sub-item" href="{$hrefi}index.php">Khóa học của tôi</a>
            <a class="sub-item" href="{$hrefs}trang_ca_nhan.php">Trang cá nhân</a>
            <a class="sub-item" href="{$hrefs}doi_mk.php">Đổi mật khẩu</a>
            <a class="logout sub-item" href="{$hrefs}dang_xuat.php">Đăng xuất</a>
          EOD;
        ?>
      </div>
    </div>
  </div>
</nav>