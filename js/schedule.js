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

function drawSchedule(arr) {
    let studentInfo = $('#studentInfo');
    studentInfo.html(
        '<span class="text-mutted">MSSV: </span>' +
        '<span class="text-color">' + arr[arr.length - 1].name + '</span>' +
        '<span class="text-mutted space_left">Họ tên: </span>' +
        '<span class="text-color">' + arr[arr.length - 1].day + '</span>' +
        '<span class="text-mutted space_left">Lớp: </span>' +
        '<span class="text-color">' + arr[arr.length - 1].start + '</span>'
    );
    for (let i = 0; i < arr.length - 1; i++) {
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
    for (let i = 0; i < arr.length - 2; i++) {
        for (let j = i + 1; j < arr.length - 1; j++) {
            if (arr[i].day > arr[j].day) {
                let temp = arr[i];
                arr[i] = arr[j];
                arr[j] = temp;
            }
        }
    }
    let table_body = $('#tbody');
    for (let i = 1; i <= 15; i++) {
        let row = document.createElement('tr');
        for (let j = 1; j <= 7; j++) {
            let col = document.createElement('td');
            if (j == 1) {
                col.className = 'stt';
                col.innerHTML = '<div>' + 'Tiết ' + i + '</div>';
            } else {
                col.id = i + '_' + j;
            }
            row.append(col);
        }
        table_body.append(row);
    }
    for (let i = 0; i < arr.length - 1; i++) {
        let start = arr[i].start;
        let day = arr[i].day;
        let total = arr[i].total;

        let idCell = start + '_' + day;
        let cell = document.getElementById(idCell);
        cell.rowSpan = arr[i].total;

        cell.innerHTML = "<span class='text-color'>" + arr[i].name + "</span>" + "<br />" +
            "<i class='text-mutted'>Phòng: </i>" +
            "<span class='text-color'>" + arr[i].room + "</span>" + "<br />";
        cell.className = 'course';

        for (let j = 0; j < total - 1; j++) {
            start++;
            document.getElementById(start + '_' + day).remove();
        }
    }
}

$('#btnSaveImage').click(function () {
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

$('#btnBack').click(function() {
    window.history.back();
});