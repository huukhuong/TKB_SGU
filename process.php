<?php
require_once './simple_html_dom.php';
require_once './Course.php';

$html = file_get_html("http://thongtindaotao.sgu.edu.vn/Default.aspx?page=thoikhoabieu&sta=1&id=3119410215");
$root = $html->find('.grid-roll2', 0);
$root = $root->plaintext;
$root = str_replace('  ', '', $root);
$root = explode("DSSV", $root);
array_pop($root);

// thay fakedat thành root
$fakedata = $root;
// list môn học
$mh = [];
// vec gì của tml Kiệt code ấy ~~
$vec = [];

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

$str = '841047 Công nghệ phần mềm014DCT1191 4 01BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV';
$name = getTenmonHoc($str);
$cutname = catBoTenMonHoc($str, $name);
$cutDuThua = catBoDuThua($cutname);

echo '<pre>';
print_r(getListDay($cutDuThua));
