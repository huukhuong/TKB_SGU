$.ajax({
    url: 'process.php',
    type: "GET",
    dataType: 'json',
    data: {
        id: $('#id').val()
    },
    success: function (data) {
        $('#loading').css('display', 'none');
        drawSchedule(data);
    }
});

const randomIntFromInterval = (min, max) => {
    return Math.floor(Math.random() * (max - min + 1) + min)
}

const drawSchedule = (arr) => {
    console.log("Dữ liệu trả về từ API:");
    console.log(arr);

    let studentInfo = $('#studentInfo');
    studentInfo.html(
        '<span class="text-mutted">MSSV: </span>' +
        '<span class="info-text-color">' + arr[arr.length - 1].name + '</span>' +
        '<span class="text-mutted space_left">Họ tên: </span>' +
        '<span class="info-text-color">' + arr[arr.length - 1].day + '</span>' +
        '<span class="text-mutted space_left">Lớp: </span>' +
        '<span class="info-text-color">' + arr[arr.length - 1].start + '</span>'
    );
    for (let i = 0; i < arr.length - 1; i++) {
        arr[i].start = parseInt(arr[i].start);
        arr[i].total = parseInt(arr[i].total);

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
    // sort từ t2 -> t7
    for (let i = 0; i < arr.length - 2; i++) {
        for (let j = i + 1; j < arr.length - 1; j++) {
            if (arr[i].day > arr[j].day) {
                let temp = arr[i];
                arr[i] = arr[j];
                arr[j] = temp;
            }
        }
    }
    // sort theo total, nhưng giữ nguyên thứ
    for (let i = 0; i < arr.length - 2; i++) {
        for (let j = i + 1; j < arr.length - 1; j++) {
            if (arr[i].total < arr[j].total && arr[i].day == arr[j].day) {
                let temp = arr[i];
                arr[i] = arr[j];
                arr[j] = temp;
            }
        }
    }
    let table_body = $('#tbody');
    // vẽ 12 hàng ngang
    for (let i = 1; i <= 12; i++) {
        let row = document.createElement('tr');
        for (let j = 1; j <= 8; j++) {
            let col = document.createElement('td');
            const className = ' col_basic';
            if (j == 1 || j == 8) {
                col.className = 'stt';
                col.innerHTML = '<div>' + 'Tiết ' + i + '</div>';
            } else {
                col.id = i + '_' + j;
                col.className = className;
            }
            row.append(col);
        }
        table_body.append(row);
    }

    for (let i = 0; i < arr.length - 1; i++) {
        let start = arr[i].start * 1;
        let day = arr[i].day * 1;
        let total = arr[i].total * 1;

        if (start == null) {
            continue;
        }

        let idCell = start + '_' + day;
        let cell = document.getElementById(idCell);
        if (cell != null) {
            if (cell.className == 'course') {
                continue;
            }
            let tengiaovien = "";

            cell.rowSpan = arr[i].total;
            if (typeof (DSGV[parseInt(arr[i].teacher)]) != "undefined") {
                tengiaovien = DSGV[parseInt(arr[i].teacher)];
                cell.innerHTML = "<span class='text-color'>" + arr[i].name + "</span>" + "<br />" +
                    "<i class='text-mutted'>Phòng: </i>" +
                    "<span class='text-color'>" + arr[i].room + "</span>" + "<br />" +
                    "<i class='text-mutted'>Giảng viên: </i>" +
                    "<span class='text-color'>" + tengiaovien + "</span>" + "<br />";
            }
            else {
                cell.innerHTML = "<span class='text-color'>" + arr[i].name + "</span>" + "<br />" +
                    "<i class='text-mutted'>Phòng: </i>" +
                    "<span class='text-color'>" + arr[i].room + "</span>" + "<br />" +
                    "<i class='text-mutted'></span>" + "<br />";
            }
            let courseType = 0;
            switch (arr[i].day) {
                case 2:
                    courseType = 0;
                    break;
                case 3:
                    courseType = 1;
                    break;
                case 4:
                    courseType = 2;
                    break;
                case 5:
                    courseType = 3;
                    break;
                case 6:
                    courseType = 4;
                    break;
                case 7:
                    courseType = 5;
                    break;
            }
            cell.className = 'course ' + cell.className + ' course-' + courseType;
        }

        for (let j = 0; j < total - 1; j++) {
            start++;
            let row = document.getElementById(start + '_' + day)
            if (row != null) {
                row.remove();
            }
        }
    }
    // thêm hàng thứ vào cuối
    const lastRow = document.createElement('tr');
    lastRow.innerHTML =
        '<td class="stt bg-white"></td>' +
        '<td class="thead_td">Thứ Hai</td>' +
        '<td class="thead_td">Thứ Ba</td>' +
        '<td class="thead_td">Thứ Tư</td>' +
        '<td class="thead_td">Thứ Năm</td>' +
        '<td class="thead_td">Thứ Sáu</td>' +
        '<td class="thead_td">Thứ Bảy</td>' +
        '<td class="stt bg-white"></td>';
    table_body.append(lastRow);
}

$('#btnSaveImage').click(() => {
    html2canvas($("#capture")[0]).then(canvas => {
        document.body.appendChild(canvas)
        $('canvas').css('display', 'none');
        const link = document.createElement('a');
        link.download = 'TKB.png';
        link.href = canvas.toDataURL();
        link.click();
        link.delete;
    });
});

$('#btnBack').click(() => {
    window.history.back();
});
