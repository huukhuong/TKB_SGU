<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Config;
use App\Models\Lecture;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use stdClass;

class WebController extends Controller
{
    //
    public function index()
    {
        $maintain = Config::where('key', 'maintain')->first();
        if ($maintain->value == 1) {
            return view('maintain', [
                'maintain' => $maintain
            ]);
        } else {
            $counter = Config::where('key', 'counter')->first();
            $topNotifications = Notification::where('position', 'top')->where('order', '>', '0')->orderBy('order')->get();
            $bottomNotifications = Notification::where('position', 'bottom')->where('order', '>', '0')->orderBy('order')->get();

            return view('home', [
                'counter' => $counter,
                'topNotifications' => $topNotifications,
                'bottomNotifications' => $bottomNotifications,
            ]);
        }
    }

    public function timetable(Request $request)
    {
        return view('timetable', [
            'id' => $request->input('id')
        ]);
    }

    public function getTimeTableByStudentId(Request $request, $id)
    {
        if (strlen($id) != 10 && strlen($id) != 5) {
            return response()->json([
                'code' => 404,
                'isSuccess' => false,
                'message' => "Mã: $id không hợp lệ",
                'additionalData' => null,
                'data' => null,
            ]);
        }
        try {
            $url = "http://thongtindaotao.sgu.edu.vn/Default.aspx?page=thoikhoabieu&sta=1&id=$id";
            // get html from website
            $html = file_get_html($url);

            // Lấy cái div chứa mớ table con, mỗi table con lại là 1 môn học
            $divNode = $html->find('.grid-roll2', 0);

            // Check xem MSSV chuẩn chưa & check block
            $block = Block::find($id);
            if (is_null($divNode) || !is_null($block)) {
                return response()->json([
                    'code' => 404,
                    'status' => 'Not found',
                    'isSuccess' => false,
                    'message' => "Không thể truy vấn dữ liệu của $id",
                    'additionalData' => null,
                    'data' => null,
                ]);
            }
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

                $listDays = $this->plaintextDatesToArray($days);
                $listRooms = $this->plaintextRoomsToArray($rooms);
                $listStarts = $this->plaintextStartsToArray($starts);
                $listTotals = $this->plaintextTotalsToArray($totals);
                $listTeachers = $this->plaintextTeachersToArray($teachers);

                $length = count($this->plaintextDatesToArray($days));

                for ($k = 0; $k < $length; $k++) {
                    $weekdayName = $listDays[$k];
                    $sectionStart = (int)$listStarts[$k];
                    $sectionTotal = (int)$listTotals[$k];
                    $sectionEnd = $sectionStart + $sectionTotal  - 1;
                    $room = $listRooms[$k];
                    $teacherCode = $listTeachers[$k];
                    $teacher = Lecture::find($teacherCode);
                    $teacherName = $teacher ? $teacher->name : 'Chưa có thông tin';

                    $course = new stdClass();
                    $course->id = $id;
                    $course->name = $name;
                    $course->weekdayName = $weekdayName;
                    $course->weekdayNumber = $this->getDayNum($weekdayName);
                    $course->sectionStart = $sectionStart;
                    $course->sectionEnd = $sectionEnd;
                    $course->totalSection = $sectionTotal;
                    $course->startTime = $this->getTimeStart($sectionStart);
                    $course->endTime = $this->getTimeEnd($sectionEnd);
                    $course->room = $room;
                    $course->teacherCode = $teacherCode;
                    $course->teacherName = $teacherName;
                    $course->group = 0;

                    $listResult[] = $course;
                }
            }

            // Sort lại môn học theo mã môn
            $courseCount = count($listResult);
            for ($i = 0; $i < $courseCount - 1; $i++) {
                for ($j = $i + 1; $j < $courseCount; $j++) {
                    if ($listResult[$i]->id < $listResult[$j]->id) {
                        $this->swap($listResult[$i], $listResult[$j]);
                    }
                }
            }

            // Đánh số theo group môn
            $group = 0;
            $preId = $listResult[0]->id;
            for ($i = 0; $i < $courseCount; $i++) {
                if ($preId != $listResult[$i]->id) {
                    $preId = $listResult[$i]->id;
                    $group++;
                }
                $listResult[$i]->group = $group;
            }

            // Sort theo ngày học (thứ)
            for ($i = 0; $i < $courseCount - 1; $i++) {
                for ($j = $i + 1; $j < $courseCount; $j++) {
                    if ($listResult[$i]->weekdayNumber > $listResult[$j]->weekdayNumber) {
                        $this->swap($listResult[$i], $listResult[$j]);
                    }
                }
            }

            // Sort theo tiết bắt đầu
            for ($i = 0; $i < $courseCount - 1; $i++) {
                for ($j = $i + 1; $j < $courseCount; $j++) {
                    if ($listResult[$i]->sectionStart > $listResult[$j]->sectionStart) {
                        $this->swap($listResult[$i], $listResult[$j]);
                    }
                }
            }

            // Get thông tin sinh viên
            $msv = $html->find('#ctl00_ContentPlaceHolder1_ctl00_lblContentMaSV', 0)->text();
            $hoTen = $html->find('#ctl00_ContentPlaceHolder1_ctl00_lblContentTenSV', 0)->text();
            $hoTen = str_replace(":", ": ", $hoTen);
            $khoa = $html->find('#ctl00_ContentPlaceHolder1_ctl00_lblContentLopSV', 0)->text();

            $student = new stdClass();
            $student->id = $msv;
            $student->name = $hoTen;
            $student->faculty = $khoa;

            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'isSuccess' => true,
                'message' => 'Dữ liệu được get thành công',
                'additionalData' => $student,
                'data' => $listResult,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'Internal Server Error',
                'isSuccess' => false,
                'message' => $e->getMessage(),
                'additionalData' => null,
                'data' => null,
            ]);
        }
    }

    private function swap(&$a, &$b)
    {
        $temp = $a;
        $a = $b;
        $b = $temp;
    }

    private function getDayNum($dayString)
    {
        switch ($dayString) {
            case 'Hai':
                return 2;
            case 'Ba':
                return 3;
            case 'Tư':
                return 4;
            case 'Năm':
                return 5;
            case 'Sáu':
                return 6;
            case 'Bảy':
                return 7;
            default:
                return 1;
        }
    }

    private function getTimeStart($section)
    {
        switch ($section) {
            case '1':
                return '7:00';
            case '2':
                return '7:50';
            case '3':
                return '9:00';
            case '4':
                return '9:50';
            case '5':
                return '10:40';
            case '6':
                return '13:00';
            case '7':
                return '13:50';
            case '8':
                return '15:00';
            case '9':
                return '15:50';
            case '10':
                return '16:40';
            case '11':
                return '17:40';
            case '12':
                return '18:30';
            case '13':
                return '19:20';
        }
    }

    private function getTimeEnd($section)
    {
        switch ($section) {
            case 1:
                return '7:50';
            case 2:
                return '8:40';
            case 3:
                return '9:50';
            case 4:
                return '10:40';
            case 5:
                return '11:30';
            case 6:
                return '13:50';
            case 7:
                return '14:40';
            case 8:
                return '15:50';
            case 9:
                return '16:40';
            case 10:
                return '17:30';
            case 11:
                return '18:30';
            case 12:
                return '19:20';
            case 13:
                return '20:10';
        }
    }

    private function plaintextDatesToArray($str)
    {
        // input: SáuBảySáuBảy
        $pieces = preg_split('/(?=[A-Z])/', $str);
        unset($pieces[0]);
        // output: [Sáu, Bảy, Sáu, Bảy]
        return array_values($pieces);
    }

    private function plaintextStartsToArray($str)
    {
        // input: 1166
        // output: [1, 1, 6, 6]
        return str_split($str);
    }

    private function plaintextTotalsToArray($str)
    {
        // input: 4445
        // output: [4, 4, 5, 5]
        return $this->plaintextStartsToArray($str);
    }

    private function plaintextRoomsToArray($str)
    {
        // input: C.S_A02C.S_A02
        $result = [];

        // input: C.A0021.B104
        preg_match_all('/.\./', $str, $address);
        $address = $address[0];
        // output: [C., 1.]

        // input: C.A0021.B104
        $room = preg_split('/.\./', $str);
        unset($room[0]);
        // output: [A002, B104]

        $n = count($address);
        for ($i = 0; $i < $n; $i++) {
            $result[] = $address[$i] . $room[$i + 1];
        }
        // output: [C.S_A02, C.S_A02]
        return array_values($result);
    }

    private function plaintextTeachersToArray($str)
    {
        // input: 1062410624
        // output: [10624, 10624]
        return str_split($str, 5);
    }
}
