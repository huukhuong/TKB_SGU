<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Xem thời khóa biểu SGU</title>
    <link rel="stylesheet" href="{{ asset('css/timetable.css') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">
</head>

<body>
    <input type="hidden" id="id" value="{{ $id }}">
    <div id="loading">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="main">
        <div id="studentInfo">
            <span class="text-mutted mr-2">MSSV:</span>
            <span class="info-text-color" id="studentId"></span>
            <span class="text-mutted mr-2 space_left">Họ tên:</span>
            <span class="info-text-color" id="studentName"></span>
            <span class="text-mutted mr-2 space_left">Lớp:</span>
            <span class="info-text-color" id="studentFaculty"></span>
        </div>
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
    <script src="{{ asset('js/timetable.js') }}"></script>
</body>

</html>
