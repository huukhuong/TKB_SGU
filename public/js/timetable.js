// Vẽ bảng rỗng
const table_body = $('#tbody');
// vẽ 12 hàng ngang
for (let i = 1; i <= 12; i++) {
  const row = document.createElement('tr');
  for (let j = 1; j <= 8; j++) {
    const className = 'col_basic';
    const col = document.createElement('td');
    if (j == 1 || j == 8) {
      col.className = 'stt';
      col.innerHTML = '<div>' + 'Tiết ' + i + '</div>';
    } else {
      col.id = `d${j}_s${i}`;
      col.className = className;
    }
    row.append(col);
  }
  table_body.append(row);
}

const id = $('#id').val();
fetch(`/api/getTimeTableByStudentId/${id}`)
  .then(jsonText => jsonText.json())
  .then(json => {
    if (json.isSuccess) {
      $('#loading').hide();
      $('#studentId').text(json.additionalData.id);
      $('#studentName').text(json.additionalData.name);
      $('#studentFaculty').text(json.additionalData.faculty);
      drawSchedule(json.data);
    } else {
      alert(json.message);
      history.back();
    }
  })
  .catch(e => {
    console.log(e);
  })

const drawSchedule = (data) => {
  data.map((item, index) => {
    const start = item.sectionStart;
    const day = item.weekdayNumber;
    const total = item.totalSection;

    const cell = $(`#d${day}_s${start}`);
    if (cell) {
      // cell.classList == 'course' : bị bỏ qua vì className không chỉ có mỗi course
      // API v2 đã fix lỗi này
      if (cell.classList && cell.classList.contains('course')) {
        // do nothing
      }
      else {
        cell.attr('rowspan', total);

        cell.html("<span class='text-color'>" + item.name + "</span>" + "<br />" +
          "<i class='text-mutted'>Phòng: </i>" +
          "<span class='text-color'>" + item.room + "</span>" + "<br />" +
          "<i class='text-mutted'>Giảng viên: </i>" +
          "<span class='text-color'>" + item.teacherName + "</span>" + "<br />");

        const courseType = item.group;
        cell.addClass('course');
        cell.addClass(`course-${courseType}`);
      }

      let affected = item.sectionStart;
      for (let j = 0; j < item.totalSection - 1; j++) {
        affected++;
        const row = $(`#d${day}_s${affected}`);
        if (row != null) {
          row.remove();
        }
      }
    }
  });
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