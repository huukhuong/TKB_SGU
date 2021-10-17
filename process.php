<?php
require_once './simple_html_dom.php';
require_once './Course.php';
$id = ""; 
if(isset($_GET['mssv'])){
    $id = $_GET['mssv'];
}
else{
    return;
}
$html = file_get_html("http://thongtindaotao.sgu.edu.vn/Default.aspx?page=thoikhoabieu&sta=1&id=$id");
$root = $html->find('.grid-roll2', 0);
$root = $root->plaintext;
$root = str_replace('  ', '', $root);
$root = str_replace('x', ' ', $root); // fix clc
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
        $temp = substr($s, 0, $list[1]-$list[0]);
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

function  getThutiet($s) {
    // input = 416238C.E402C.E4021154111541123456789012345123456789012345DSSV
    $i = 0;
    for ($i = 0; $i < strlen($s); $i++) {
        if (is_numeric($s[$i])) {
            break;
        }
    }
    $temp = substr($s, 0, $i);
    $s  = str_replace($temp, "", $s);
    for ($i = 0; $i < strlen($s); $i++) {
        if (!is_numeric($s[$i])) {
            break;
        }
    }
    $temp = substr($s, 0, $i);
    return $temp;
    // out = 416238
}

function getdanhsachtiet($s){
    if(strlen($s) % 2 != 0){
        $s = substr($s, 0, strlen($s) -1 );
        echo $s;
    }
    GLOBAL $tietbd ;
    GLOBAL $tietkt ;
    $tietbd = [];
    $tietkt = [];
    if(strlen($s) == 2){
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
    }
}

foreach($root as $str){
    GLOBAL $vec;
    $name = getTenmonHoc($str);
    $cutname = catBoTenMonHoc($str, $name);
    $cutDuThua = catBoDuThua($cutname);
    $vec = getlistDay($cutDuThua);
    getdanhsachtiet(getThutiet($cutDuThua));
    for($k = 0 ; $k <sizeof($vec); $k++){
        $arr =[
            "name" => $name,
            "day" => $vec[0],
            "start" => $tietbd[0],
            "total" => $tietkt[0],
            "room" => "..."
        ];
        $mh[] = $arr;
    }
}
echo json_encode($mh,JSON_UNESCAPED_UNICODE);
