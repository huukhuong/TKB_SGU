<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem thời khóa biểu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <?php include './favicon.php'; ?>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
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
    </div>
</body>

</html>