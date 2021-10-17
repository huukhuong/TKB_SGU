drawBorder();
$('#loading').css('display', 'flex');
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

function drawBorder() {
    let table_up = $('#table_up');
    for (let i = 1; i <= 12; i++) {
        let row = document.createElement('tr');
        row.className = 'row';
        let rowTitle = document.createElement('td');
        rowTitle.innerText = 'Tiết ' + i;
        rowTitle.className = 'header1';
        row.append(rowTitle);

        for (let j = 2; j < 8; j++) {
            let course = document.createElement('td');
            row.append(course);
        }
        table_up.append(row);
    }
}
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
    let table_body = $('#table_body');
    for (let i = 1; i <= 12; i++) {
        let row = document.createElement('tr');
        row.className = 'row';
        let rowTitle = document.createElement('td');
        rowTitle.className = 'header1';
        row.append(rowTitle);

        for (let j = 2; j < 8; j++) {
            let toDay = [];
            for (let t = 0; t < arr.length - 1; t++) {
                if (arr[t].day == j) {
                    toDay.push(arr[t]);
                }
            }
            let course = document.createElement('td');
            course.className = 'cell';
            if (toDay.length != 0) {
                for (let k = 0; k < toDay.length; k++)
                    if (toDay[k].start == i) {
                        course.className = 'course';
                        course.innerHTML =
                            "<span class='text-color'>" + toDay[k].name + "</span>" + "<br />" +
                            "<i class='text-mutted'>Phòng: </i>" +
                            "<span class='text-color'>" + toDay[k].room + "</span>" + "<br />"
                        course.rowSpan = toDay[k].total;
                    }
            }
            row.append(course);
        }
        table_body.append(row);
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
    })
}