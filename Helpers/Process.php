<?php
error_reporting(E_ALL & ~E_NOTICE);
$id = $_GET['id'];

require_once "./simple_dom/simple_html_dom.php";
require_once "./Functions.php";

// get html from website
$html = file_get_html("http://thongtindaotao.sgu.edu.vn/Default.aspx?page=thoikhoabieu&sta=1&id=$id");

// Lấy cái div chứa mớ table con, mỗi table con lại là 1 môn học
$divNode = $html->find('.grid-roll2', 0);

// Get list table, mỗi table là 1 môn
// Phải tìm theo class & style: width=100% vì trong mỗi thằng lại có cả mớ table nữa
$courseList = $divNode->find('table[width*="100%"]');
$courseCount = count($courseList);
$listResult = [];
for ($i = 0; $i < $courseCount; $i++) {

    /*
        0 => 862101
        1 => Giáo dục thể chất (I)
    */
    $item = $courseList[$i]->find('td');

    /*
        <td "width=35px">
        0 => 13 
        1 => 1 
        4 => 1062410624     ===> Mã GV đây
    */
    $itemWidth35 = $courseList[$i]->find('td[width*="35px"]');

    /* 
        <td "width=40px">
        0 => SáuBảySáuBảy   ===> Những ngày học
        1 => 1166           ===> Những tiết bắt đầu (ứng với ngày ở trên)
        2 => 4445           ===> Tổng số tiết (tiết kt = tiết bđ + tồng)
        3 => DSSVDSSVDSSVDSSVDSSV 
    */
    $itemWidth40 = $courseList[$i]->find('td[width*="40px"]');
    /*
        <td "width=50px">
        0 => C.S_A02C.S_A02
    */
    $itemWidth50 = $courseList[$i]->find('td[width*="50px"]');

    $id = trim($item[0]->plaintext);
    $name = trim($item[1]->plaintext);
    $days = trim($itemWidth40[0]->plaintext);
    $starts = trim($itemWidth40[1]->plaintext);
    $totals = trim($itemWidth40[2]->plaintext);
    $rooms = trim($itemWidth50[0]->plaintext);
    $teachers = strlen($id) == 5 ? $id : trim($itemWidth35[4]->plaintext); // Nếu gv xem thì lấy luôn mã gv

    $listDays = plaintextDatesToArray($days);
    $listRooms = plaintextRoomsToArray($rooms);
    $listStarts = plaintextStartsToArray($starts);
    $listTotals = plaintextTotalsToArray($totals);
    $listTeachers = plaintextTeachersToArray($teachers);

    $length = count(plaintextDatesToArray($days));

    for ($k = 0; $k < $length; $k++) {
        $course = [
            "id" => $id,
            "name" => $name,
            "day" => $listDays[$k],
            "start" => $listStarts[$k],
            "total" => $listTotals[$k],
            "room" => $listRooms[$k],
            "teacher" => $listTeachers[$k]
        ];
        $listResult[] = $course;
    }
}

// Get thông tin sinh viên
$msv = $html->find('#ctl00_ContentPlaceHolder1_ctl00_lblContentMaSV', 0);
$hoTen = $html->find('#ctl00_ContentPlaceHolder1_ctl00_lblContentTenSV', 0);
$khoa = $html->find('#ctl00_ContentPlaceHolder1_ctl00_lblContentLopSV', 0);

$course = [
    "id" =>  "",
    "name" => $msv->plaintext,
    "day" => $hoTen->plaintext,
    "start" => $khoa->plaintext,
    "totals" => "",
    "rooms" => "C.E402",
    "teachers" => "-1"
];
$listResult[] = $course;
// output hiện tại
echo json_encode($listResult, JSON_UNESCAPED_UNICODE);

// write log
require_once "./writeLog.php";