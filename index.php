<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/khoa_hoc.css">
    <link rel="stylesheet" href="./css/footer.css">
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
        include './function.php';
        include "./src/navbar.php";
        ?>
    </header>
    <section>
        <?php
        if (isLogin()) {
            include './src/khoa_hoc.php';
        }
        ?>
    </section>

</body>
<footer>
    <?php
    include "./src/footer.php";
    ?>
</footer>

</html>