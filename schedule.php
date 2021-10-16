<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem thời khóa biểu</title>
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    table,
    td,
    th {
        border: 1px solid #414141;
    }

    td {
        width: 220px;
        height: 45px;
    }

    .main {
        height: 150vh;
        min-width: 1400px;
        padding: 50px 0;
        display: flex;
        justify-content: center;
        position: relative;
    }

    .table,
    .table_absolute {
        border-collapse: collapse;
        position: absolute;
    }

    .header,
    .header1 {
        background-color: #2D8ECE;
        color: #fff;
        font-size: 1rem;
        font-weight: bold;
        padding: 2px 0;
        text-align: center;
    }

    .header1 {
        width: 120px !important;
    }

    .course {
        vertical-align: middle;
        text-align: start;
        padding: 0 4px;
        background-color: #F5F5DC;
        position: relative;
        z-index: 5;
    }

    .cell {
        position: absolute;
        border: 0;
    }

    .text-color {
        color: #31755E;
        font-weight: bold;
    }

    .text-mutted {
        color: #80808C;
        font-weight: bold;
    }
</style>

<body>
    <?php
    if (!isset($_POST['id'])) {
        echo 'Chưa nhập mã sinh viên';
        die();
    }
    $id = $_POST['id'];
    ?>
    <div class="main">
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

    <script>
        let arr = [{
                "name": "Công nghệ phần mềm",
                "day": "Ba",
                "start": 1,
                "total": 3,
                "room": "C.E402"
            },
            {
                "name": "Công nghệ phần mềm",
                "day": "Ba",
                "start": 4,
                "total": 2,
                "room": "C.E402"
            },
            {
                "name": "Hệ điều hành",
                "day": "Tư",
                "start": 6,
                "total": 2,
                "room": "C.E604"
            },
            {
                "name": "Hệ điều hành",
                "day": "Năm",
                "start": 6,
                "total": 2,
                "room": "C.A109"
            },
            {
                "name": "Thiết kế giao diện",
                "day": "Tư",
                "start": 9,
                "total": 2,
                "room": "C.A208"
            },
            {
                "name": "Thiết kế giao diện",
                "day": "Sáu",
                "start": 1,
                "total": 2,
                "room": "C.A208"
            },
            {
                "name": "Các hệ quản trị cơ sở dữ liệu",
                "day": "Năm",
                "start": 1,
                "total": 2,
                "room": "C.C106"
            },
            {
                "name": "Các hệ quản trị cơ sở dữ liệu",
                "day": "Năm",
                "start": 4,
                "total": 2,
                "room": "C.A106"
            },
            {
                "name": "Phân tích thiết kế hướng đối tượng",
                "day": "Ba",
                "start": 6,
                "total": 2,
                "room": "C.A208"
            },
            {
                "name": "Phân tích thiết kế hướng đối tượng",
                "day": "Ba",
                "start": 8,
                "total": 3,
                "room": "C.E302"
            },
        ];

        for (let i = 0; i < arr.length; i++) {
            switch (arr[i].day) {
                case 'Hai':
                    arr[i].day = 2;
                    break;
                case 'Ba':
                    arr[i].day = 3;
                    break;
                case 'Tư':
                    arr[i].day = 4;
                    break;
                case 'Năm':
                    arr[i].day = 5;
                    break;
                case 'Sáu':
                    arr[i].day = 6;
                    break;
                case 'Bảy':
                    arr[i].day = 7;
                    break;
            }
        }
        let table_body = document.getElementById('table_body');
        for (let i = 1; i <= 10; i++) {
            let row = document.createElement('tr');
            row.className = 'row';
            let rowTitle = document.createElement('td');
            rowTitle.innerText = 'Tiết ' + i;
            rowTitle.className = 'header1';
            row.appendChild(rowTitle);

            for (let j = 2; j < 8; j++) {
                let toDay = [];
                for (let t = 0; t < arr.length; t++) {
                    if (arr[t].day === j) {
                        toDay.push(arr[t]);
                    }
                }
                let course = document.createElement('td');
                course.className = 'cell';
                if (toDay.length != 0) {
                    for (let k = 0; k < toDay.length; k++)
                        if (toDay[k].start === i) {
                            course.className = 'course';
                            course.innerHTML =
                                "<span class='text-color'>" + toDay[k].name + "</span>" + "<br />" +
                                "<i class='text-mutted'>Phòng: </i>" +
                                "<span class='text-color'>" + toDay[k].room + "</span>" + "<br />"
                            course.rowSpan = toDay[k].total;
                        }
                }
                row.appendChild(course);
            }
            table_body.appendChild(row);
        }

        let table_up = document.getElementById('table_up');
        for (let i = 1; i <= 10; i++) {
            let row = document.createElement('tr');
            row.className = 'row';
            let rowTitle = document.createElement('td');
            rowTitle.className = 'header1'
            rowTitle.style.cssText = 'background: transparent';
            row.appendChild(rowTitle);

            for (let j = 2; j < 8; j++) {

                let course = document.createElement('td');
                row.appendChild(course);
            }
            table_up.appendChild(row);
        }
    </script>
</body>

</html>