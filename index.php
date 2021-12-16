<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem thời khóa biểu SGU</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <?php
    include './favicon.php';
    ?>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="w-100 text-center"><img width="120px" src="./img/logo.png" alt="logo"></div>
            <h3 class="text-center w-100 py-3">Xem thời khóa biểu theo tuần SGU</h3>
            <p class="text-center alert alert-danger mx-2">Website chỉ là giải pháp tạm thời, nhà trường sẽ sớm mở lại chức năng xem TKB theo tuần</p>
            <form action="./schedule.php" method="post" class="col-md-6 col-12">
                <div class="form-group">
                    <label>Nhập mã sinh viên</label>
                    <input type="text" class="form-control" name="id" required>
                </div>
                <div style="text-align: center;">
                    <input class="btn btn-primary" type="submit" value="Xem thời khóa biểu">
                </div>
            </form>
        </div>
        <div class="text-center">
            <?php
            require_once './connection.php';
            
            $sql = "SELECT * FROM `count`";
            $query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($query);
            
            echo 'Số lượt truy cập: ' . $row['countNum'];
            ?>
        </div>
        <div class="py-5">
            <h5 class="text-center alert alert-danger mt-2">
                Vì trang web được viết gấp rút trong thời gian ngắn
                nên không thể tránh khỏi các lỗi phát sinh <br />
                Mong các bạn thông cảm
            </h5>
            <h5 class="text-center">
                Nếu chức năng lưu ảnh bị lỗi vui lòng chụp màn hình thủ công
            </h5>
            <h5 class="text-center mt-5">Liên hệ báo lỗi:</h5>
            <h6 class="text-center">Võ Hoàng Kiệt - K19 CNTT | <a target="_blank" href="https://www.facebook.com/thekids.1002/">Liên hệ</a></h6>
            <h6 class="text-center">Trần Hữu Khương - K19 CNTT | <a target="_blank" href="https://www.facebook.com/kayden.khuong/">Liên hệ</a></h6>
        </div>

    </div>
</body>

</html>