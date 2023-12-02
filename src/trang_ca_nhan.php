<?php
include '../function.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang cá nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- End bootstrap cdn -->
    <style>
        img {
            width: 300px;
            height: 300px;
            border-radius: 50%;
        }
    </style>
</head>
<?php
include 'navbar.php';
?>

<body>
    <main style="min-height: 90vh; margin-top: 10%; ">
        <div class="d-flex justify-content-center">
            <h1>Thông tin</h1>
        </div>
        <div class="d-flex flex-column">
            <div class="d-flex justify-content-center">
                <div class="d-flex mt-5 bg-light p-5">
                    <div>
                        <div class="mb-3">
                            <img class="shadow" src="<?php
                                        $sql = "SELECT * FROM `user` WHERE id_user = '{$_SESSION['login']['id']}'";
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        echo '../images/avt/' . $row['img_avt'];
                                        ?>" alt="">
                        </div>
                    </div>
                    <div class="ms-5 "> <!-- Added margin to create space between the avatar and text -->
                        <div class="mb-3">
                            <h4>Họ và tên: <?php
                                            $sql = "SELECT * FROM `user` WHERE id_user = '{$_SESSION['login']['id']}'";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            echo $row['name'];
                                            ?>
                            </h4>
                        </div>
                        <div class="mb-3">
                            <h4>Ngày sinh: <?php
                                            $sql = "SELECT * FROM `user` WHERE id_user = '{$_SESSION['login']['id']}'";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            echo $row['doB'];
                                            ?>
                            </h4>
                        </div>
                        <div>
                            <h4> Khoa: <?php
                                        $sql = "SELECT * FROM `user` JOIN khoa ON user.id_khoa = khoa.id_khoa WHERE id_user = '{$_SESSION['login']['id']}'";
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        echo $row['ten_khoa'] ?>
                            </h4>
                        </div>
                    </div>
                </div>


            </div>




        </div>
    </main>
</body>

</html>