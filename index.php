<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem thời khóa biểu</title>
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
            $file = "bodem.log";
            $act = fopen($file, "r");
            $dem = fread($act, filesize($file));
            fclose($act);
            echo 'Số lượt truy cập: ' . $dem;
            ?>
        </div>
        <div class="py-5">
            <h5 class="text-center mt-2">Web còn một số lỗi nhỏ đối với những bạn có 2 buổi học từ tiết 11 trong tuần</h5>
            <h5 class="text-center">Nếu chức năng lưu ảnh bị lỗi vui lòng chụp màn hình thủ công</h5>
            <h6 class="text-center mt-5">Nhân sự thực hiện:</h5>
            <h6 class="text-center">Võ Hoàng Kiệt - K19 CNTT</h6>
            <h6 class="text-center">Trần Hữu Khương - K19 CNTT</h6>
        </div>

    </div>
</body>

</html>