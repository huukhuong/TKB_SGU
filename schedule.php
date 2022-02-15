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
    <?php 
        include './favicon.php'; 
        include './count.php';
    ?>
</head>

<body>
    <input type="hidden" id="id" value="<?= $id ?>">
    <div id="loading">
        <img src="./img/loading.gif">
    </div>
    <button class="btn" id="btnBack">Quay lại</button>
    <button class="btn" id="btnSaveImage">Lưu ảnh</button>
    <div id="studentInfo"></div>
    <div id="capture">
        <table id="table">
            <thead>
                <td class="stt" style="width: 100px; max-width: 100px; min-width: 100px;">
                    <div></div>
                </td>
                <td class="thead_td">Thứ Hai</td>
                <td class="thead_td">Thứ Ba</td>
                <td class="thead_td">Thứ Tư</td>
                <td class="thead_td">Thứ Năm</td>
                <td class="thead_td">Thứ Sáu</td>
                <td class="thead_td">Thứ Bảy</td>
            </thead>
            <tbody id="tbody"></tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="./js/dsgv.js"></script>
    <script src="./js/schedule.js"></script>
</body>

</html>