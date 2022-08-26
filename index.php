<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem thời khoá biểu SGU</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css">
    <?php
    include './Helpers/favicon.php';
    require './Helpers/clearCache.php';
    require_once './Helpers/connection.php';
    $sql = "SELECT * FROM `notifications`";
    $query = mysqli_query($conn, $sql);
    $noti = mysqli_fetch_assoc($query);
    if ($noti['maintain'] == 1) {
		include './maintain.html';
      	die();
    }
    ?>
    <link rel="stylesheet" href="./css/index.css?time=<?= time() ?>">
</head>

<body>
    <div class="container" style="flex: 1;">
        <div class="row justify-content-center w-100 py-5">
            <div class="col-lg-6 col-12">
                <div class="main-content">
                    <div class="text-center">
                        <img src="./img/logo.png" alt="logo" class="logo">
                        <h2 class="title">Thời khoá biểu SGU</h2>
                        <h6 class="info text-center">
                            Dữ liệu được cập nhật từ trang web chính thức của nhà trường: <br>
                            <a href="http://thongtindaotao.sgu.edu.vn/">thongtindaotao.sgu.edu.vn</a>
                        </h6>
                    </div>
                    <?php
                          if ($noti['showWarning'] == 1) {
                          ?>
                              <p class="alert alert-warning mt-2"><?=$noti['warning']?></p>
                          <?php
                          }
                          if ($noti['showDanger'] == 1) {
                          ?>
                              <p class="alert alert-danger mt-2"><?=$noti['danger']?></p>
                          <?php
                          }
                          if ($noti['showSuccess'] == 1) {
                          ?>
                              <p class="alert alert-success mt-2"><?=$noti['success']?></p>
                          <?php
                          }
                    ?>
                    <div class="form mt-0">
                        <form action="./schedule.php" method="post">
                            <div class="shadow"></div>
                            <div class="form-group">
                                <i class="fas fa-search icon-form"></i>
                                <input type="number" step="1" autocomplete="on" placeholder="Nhập mã sinh viên..." class="form-control input-form" name="id" required>
                               <input class="btn btn-primary btn-form text-bold" type="submit" value="Tìm" />
                            </div>
                        </form>
                    </div>

                    <div class="text-center mt-4 mb-5">
                        Số lượt truy cập:
                        <?php

                        $sql = "SELECT * FROM `count` WHERE `pageName`='schedule'";
                        $query = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($query);

                        echo number_format($row['countNum'], 0, '.', '.');
                        ?>
                    </div>

                    <p class="text-center mt-2">
                        Ủng hộ bọn mình bằng cách <br />
                        <a href="https://123host.vn/hosting-mien-phi.html?utm_source=INV&utm_medium=FHREF&utm_campaign=132151">đăng ký hosting miễn phí</a> được tài trợ bởi <b>123HOST</b>
                    </p>

                  <p class="mt-4 mb-5 alert alert-success text-center">
                  	<?=$noti['extend']?>      
                  </p>
                </div>
            </div>
        </div>

        <div class="footer mt-5 p-2">
            <p class="text-bold text-center m-0">Nhóm tác giả</p>
            <div class="d-flex justify-content-center">
                <a class="mx-2" href="https://www.facebook.com/thekids.1002/">
                    <i class="fab fa-facebook"></i> <span class="text-bold">Võ Hoàng Kiệt</span>
                </a>
                <a class="mx-2" href="https://www.facebook.com/kayden.khuong/">
                    <i class="fab fa-facebook"></i> <span class="text-bold">Trần Hữu Khương</span>
                </a>
            </div>
        </div>

</body>

</html>