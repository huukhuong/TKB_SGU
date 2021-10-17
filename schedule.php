<?php
if (!isset($_POST['id'])) {
    echo 'Chưa nhập mã sinh viên';
    die();
}
$id = $_POST['id'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem thời khóa biểu</title>
    <link rel="stylesheet" href="./css/schedule.css">
</head>

<body>
    <div style="text-align: center; padding-top: 20px">
        <button id="btnSaveImage">Save image</button>
    </div>
    <div id="loading">
        <img src="./img/loading.gif">
    </div>
    <div class="main" id="capture">
        <div id="studentInfo" style="width: 100vw;text-align: center;"></div>
        <input type="hidden" id="id" value="<?= $id ?>">
        <table class="table">
            <thead>
                <tr>
                    <td class="header1"></td>
                    <td class="header">Thứ hai</td>
                    <td class="header">Thứ ba</td>
                    <td class="header">Thứ tư</td>
                    <td class="header">Thứ năm</td>
                    <td class="header">Thứ sáu</td>
                    <td class="header">Thứ bảy</td>
                </tr>
            </thead>
            <tbody id="table_body"></tbody>
        </table>

        <table class="table table_absolute">
            <thead>
                <tr>
                    <td class="header1"></td>
                    <td class="header">Thứ hai</td>
                    <td class="header">Thứ ba</td>
                    <td class="header">Thứ tư</td>
                    <td class="header">Thứ năm</td>
                    <td class="header">Thứ sáu</td>
                    <td class="header">Thứ bảy</td>
                </tr>
            </thead>
            <tbody id="table_up"></tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="./js/schedule.js"></script>
</body>

</html>