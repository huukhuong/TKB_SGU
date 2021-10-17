<?php
require_once './models/simple_html_dom.php';
require_once './models/Course.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo 'Chưa nhập mã sinh viên';
    die();
}
$html = file_get_html("http://thongtindaotao.sgu.edu.vn/Default.aspx?page=thoikhoabieu&sta=1&id=$id");
$root = $html->find('.grid-roll2', 0);
$root = $root->plaintext;
$root = str_replace('  ', '', $root);
$root = str_replace('x', ' ', $root); // fix chất lượng cao , clc có dấu x 
$root = explode("DSSV", $root);
array_pop($root);

// thay fakedat thành root
$fakedata = $root;
// list môn học
$mh = [];
// vec gì của tml Kiệt code ấy ~~
$vec = [];
//danh sách tiết bắt đầu
$tietbd = [];
// danh sách số tiết
$sotiet = [];
//danh sách phòng
$listroom = [];

function getTenmonHoc($str)
{
    // input ="841047 Công nghệ phần mềm014DCT1191 4
    // 01BaBa4123C.E402C.E4021154111541123456789012345123456789012345DSSV"
    // output = "Công nghệ phần mềm";
    $temp = trim($str, ' ');
    for ($i = 0; $i < strlen($temp); $i++) {
        if ($i < 7) {
            $temp[$i] = ' '; // Xóa mã môn
        } elseif (is_numeric($temp[$i])) {
            $temp = substr($temp, 0, $i); // lấy từ đầu đến vị trí phát hiện số (Nhóm môn)
            break;
        }
    }
    return trim($temp, ' ');
}

function catBoTenMonHoc($str, $courseName)
{
    // input : a = 841047 Công nghệ phần mềm014DCT1191 4
    // 01BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
    // b = Công nghệ phần mềm
    $index = strpos($str, $courseName) + strlen($courseName);
    return substr($str, $index);
    // output = 014DCT1191 4
    // 01BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
}

function catBoDuThua($str)
{
    // intput = 014DCT1191 4
    // 01BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
    // output= BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
    if (strrpos($str, " ") != -1) {
        $lastIndex = strrpos($str, " ");
        $temp = substr($str, 0, $lastIndex + 1);
        $str = str_replace($temp, "", $str);
    }
    if (is_numeric($str[0]) && is_numeric($str[1])) {
        $str[0] = ' ';
        $str[1] = ' ';
        $str = trim($str, ' ');
    }
    return $str;
}

function getThu($str)
{
    // input: BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
    // output: BaSáuBa
    $temp = '';
    for ($i = 0; $i < strlen($str); $i++) {
        if (is_numeric($str[$i])) {
            $temp = substr($str, 0, $i);
            break;
        }
    }
    return $temp;
}

function getlistDay($s)
{
    // intput =
    // BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
    $vec = [];
    $s = cutNumber($s);
    // s = BaSáuBa
    $list = getListDays($s);
    // list này trả về vị trí của các chữ in hoa trong chuỗi s. Từ đó cắt theo vị
    // trí.
    if (count($list) == 1) {
        $temp = $s;
        $vec[] = $temp;
    } else if (count($list) == 2) {
        $temp = substr($s, 0, $list[1]);
        $temp2 = substr($s, $list[1], strlen($s));
        $vec[] = $temp;
        $vec[] = $temp2;
    } else {
        $temp = substr($s, 0, $list[1] - $list[0]);
        $temp2 = substr($s, $list[1], $list[2] - $list[1]);
        $temp3 = substr($s, $list[2], strlen($s));
        $vec[] = $temp;
        $vec[] = $temp2;
        $vec[] = $temp3;
    }
    return $vec;
    // trả về 1 arraylist các thứ
}

// Lấy vị trí của các từ in hoa trong chuỗi
function getListDays($str)
{
    $list = [];
    for ($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] > 'A' && $str[$i] < 'Z') {
            $list[] = $i;
        }
    }
    return $list;
}

// Lấy vị trí của dấu chấm
function getIndexDots($str)
{
    $list = [];
    for ($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] == '.') {
            $list[] = $i;
        }
    }
    return $list;
}

function getRoom($str)
{
    $tm = getThu($str);
    $str =  str_replace($tm, '', $str);
    //416238C.E402C.E4021154111541123456789012345123456789012345DSSV
    $tm = getThutiet($str);
    if (strlen($tm) % 2 != 0) {
        $tm = substr($tm, 0, strlen($tm) - 1); // fix cơ sở 1 & 2.
    }
    $str =  str_replace($tm, '', $str);
    //C.E402C.E4021154111541123456789012345123456789012345DSSV
    $listroom = [];
    $listdots = getIndexDots($str);
    for ($index = 0; $index < sizeof($listdots); $index++) {
        $valueOflistdots = $listdots[$index];
        if ($str[$valueOflistdots + 1] == 'S') { // fix lỗi sân bóng đá , sân quốc phòng không hiện đủ thông tin
            $tmp = substr($str, $listdots[$index] - 1, 7);
            $listroom[] = $tmp;
        } else {
            $tmp = substr($str, $listdots[$index] - 1, 6);
            $listroom[] = $tmp;
        }
    }
    return $listroom;
}
function cutNumber($str)
{
    // input: BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
    // output: BaSáuBa
    $temp = '';
    for ($i = 0; $i < strlen($str); $i++) {
        if (is_numeric($str[$i])) {
            $temp = substr($str, 0, $i);
            break;
        }
    }
    return $temp;
}

function  getThutiet($s)
{
    // input = BaBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
   
    $i = 0;
    for ($i = 0; $i < strlen($s); $i++) {
        if (is_numeric($s[$i])) {
            break;
        }
    }
    $temp = substr($s, 0, $i);
    $s  = str_replace($temp, "", $s);
    $listroom = [];
    $listdots = getIndexDots($s);
    for ($i = 0; $i < $listdots[0]; $i++) {
        if (!is_numeric($s[$i])) {
            break;
        }
    }
    $temp = substr($s, 0, $i);
    
    return $temp;
    // out = 416238
}

function getdanhsachtiet($s)
{ 
    $indexof11 = strpos($s,"11");
    
    $temp = "";
    global $tietbd;
    global $tietkt;
    $tietbd = [];
    $tietkt = [];
    if($indexof11 > 0){
      /*   echo "input ". $s;
    echo "<br>";
    echo "index" . $indexof11;
    echo "<br>"; */
        for($idx = 0 ; $idx < strlen($s);  $idx++){
            if($idx != $indexof11 && $idx != strlen($s)){
                $temp .= $s[$idx] . '_';
            }
            else{
                $temp .= $s[$idx] . '';
            }
        }
        $s = $temp;
      /*   echo "Temp =".$temp;
        echo "<br>"; */
        $tiet = explode('_',$s);
        for ($l = 0; $l < sizeof($tiet) / 2; $l++) {
            $temp =  $tiet[$l];
            $tietbd[] = $temp;
        }
        for ($l = sizeof($tiet) / 2; $l < sizeof($tiet); $l++) {
            $temp =  $tiet[$l];
            $tietkt[] = $temp;
        }
        
    }
    else{
        if (strlen($s) % 2 != 0) {
            $s = substr($s, 0, strlen($s) - 1);
        }
        for ($l = 0; $l < strlen($s) / 2; $l++) {
            $temp =  $s[$l];
            $tietbd[] = $temp;
        }
        for ($l = strlen($s) / 2; $l < strlen($s); $l++) {
            $temp =  $s[$l];
            $tietkt[] = $temp;
        }
    }

   
    /*  if(strlen($s) == 2){
        $temp =  $s[0];
        $temp2 = $s[1];
        $tietbd[] = $temp;
        $tietkt[] = $temp2;
    }
    else if(strlen($s) == 4){
        $temp =  $s[0];
        $temp2 = $s[1];
        $temp3 = $s[2];
        $temp4 = $s[3];
        $tietbd[] = $temp;
        $tietbd[] = $temp2;
        $tietkt[] = $temp3;
        $tietkt[] = $temp4;
    }
    else{
        $temp =  $s[0];
        $temp2 = $s[1];
        $temp3 = $s[2];
        $temp4 = $s[3];
        $temp5 = $s[4];
        $temp6 = $s[5];
        $tietbd[] = $temp;
        $tietbd[] = $temp2;
        $tietbd[] = $temp3;
        $tietkt[] = $temp4;
        $tietkt[] = $temp5;
        $tietkt[] = $temp6;
    } */
}

foreach ($root as $str) {
    global $vec;
    $name = getTenmonHoc($str);
    $cutname = catBoTenMonHoc($str, $name);
    $cutDuThua = catBoDuThua($cutname);
    $vec = getlistDay($cutDuThua);
    getdanhsachtiet(getThutiet($cutDuThua));
    // BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
    $listroom = getRoom($cutDuThua);
    for ($k = 0; $k < sizeof($vec); $k++) {
        $arr = [
            "name" => $name,
            "day" => $vec[$k],
            "start" => $tietbd[$k],
            "total" => $tietkt[$k],
            "room" => $listroom[$k]
        ];
        $mh[] = $arr;
    }
}

$msv = $html->find('#ctl00_ContentPlaceHolder1_ctl00_lblContentMaSV', 0);
$hoTen = $html->find('#ctl00_ContentPlaceHolder1_ctl00_lblContentTenSV', 0);
$khoa = $html->find('#ctl00_ContentPlaceHolder1_ctl00_lblContentLopSV', 0);

$arr = [
    "name" => $msv->plaintext,
    "day" => $hoTen->plaintext,
    "start" => $khoa->plaintext,
    "total" => "2",
    "room" => "C.E402"
];
$mh[] = $arr;

echo json_encode($mh, JSON_UNESCAPED_UNICODE);
