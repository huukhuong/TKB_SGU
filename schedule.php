<?php
if (!isset($_POST['id'])) {
    echo 
    '<script>
        alert("Chưa nhập mã sinh viên")
        history.back()
    </script>';
}
$id = $_POST['id'];
require('./Helpers/clearCache.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Xem thời khóa biểu</title>
    <link rel="stylesheet" href="./css/schedule.css?time=<?=time()?>" />
    <?php
    include './Helpers/favicon.php';
    include './Helpers/count.php';
    ?>
</head>

<body>
    <input type="hidden" id="id" value="<?= $id ?>">
    <div id="loading">
        <img src="./img/loading.gif">
    </div>
    <!--<button class="btn" id="btnBack">Quay lại</button>-->
    <!--<button class="btn" id="btnSaveImage">Lưu ảnh</button>-->
    <div class="main">
        <div id="studentInfo"></div>
        <div id="capture">
            <table id="table">
                <thead>
                    <td class="stt bg-white"></td>
                    <td class="thead_td">Thứ Hai</td>
                    <td class="thead_td">Thứ Ba</td>
                    <td class="thead_td">Thứ Tư</td>
                    <td class="thead_td">Thứ Năm</td>
                    <td class="thead_td">Thứ Sáu</td>
                    <td class="thead_td">Thứ Bảy</td>
                    <td class="stt bg-white"></td>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="./js/dsgv.js?time=<?=time()?>"></script>
    <script src="./js/schedule.js?time=<?=time()?>"></script>
</body>

</html>