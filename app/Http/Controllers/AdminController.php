<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Config;
use App\Models\Lecture;
use App\Models\Notification;
use App\Models\Skip;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function index()
    {
        $maintain = Config::where('key', 'maintain')->first();
        $counter = Config::where('key', 'counter')->first();
        $lecturesCount = Lecture::count();
        $countBlock = Block::count();
        $countPass = Skip::count();
        return view('admin/index', [
            'page' => 'index',
            'pageExtends' => '',
            'maintain' => $maintain,
            'counter' => $counter,
            'lecturesCount' => $lecturesCount,
            'countBlock' => $countBlock,
            'countPass' => $countPass
        ]);
    }

    public function saveMaintainConfig(Request $request)
    {
        Config::where('key', 'maintain')
            ->update([
                'value' => $request->input('maintain'),
                'content' => $request->input('maintain-content')
            ]);
        return redirect('admin');
    }

    public function getLogin()
    {
        return view('admin/login');
    }

    public function postLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $remember = $request->input('remember') == 'on';

        if (Auth::attempt(['username' => $username, 'password' => $password], $remember)) {
            return redirect('admin');
        } else {
            return back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('admin');
    }

    public function student()
    {
        $students = Student::orderBy('visited_at', 'DESC')->paginate(200);
        return view('admin/student', [
            'page' => 'students',
            'pageExtends' => '',
            'type' => 'byName',
            'keyword' => '',
            'students' => $students
        ]);
    }

    public function searchStudent(Request $request)
    {
        $type = $request->input('type');
        $keyword = $request->input('keyword');
        $keywords = explode("\n", str_replace("\r", "", $keyword));

        if ($type == 'byName') {
            $students =
                Student::where(function ($query) use ($keywords) {
                    for ($i = 0; $i < count($keywords); $i++) {
                        $query->orwhere('name', 'like',  '%' . $keywords[$i] . '%');
                    }
                })->paginate(200);
        } else {
            $students = Student::whereIn('id', $keywords)->orderBy('visited_at', 'DESC')->paginate(200);
        }
        return view('admin/student', [
            'page' => 'students',
            'pageExtends' => '',
            'type' => $type,
            'keyword' => $keyword,
            'students' => $students
        ]);
    }


    public function lecture()
    {
        $lectures = Lecture::orderBy('created_at', 'ASC')->paginate(100);
        return view('admin/lecture', [
            'page' => 'lectures',
            'pageExtends' => '',
            'lectures' => $lectures
        ]);
    }

    public function addLecture(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $lecture = new Lecture;
        $lecture->id = $id;
        $lecture->name = $name;
        $lecture->save();
        return redirect('admin/lectures');
    }

    public function skip()
    {
        $students = Skip::leftJoin('students', 'skips.id', '=', 'students.id')->get();
        return view('admin/skip', [
            'page' => 'skips',
            'pageExtends' => '',
            'students' => $students
        ]);
    }

    public function deleteSkip()
    {
        $id = request('id');
        Skip::where('id', $id)->delete();
        return redirect('admin/skips');
    }

    public function addSkip(Request $request)
    {
        $id = $request->input('id');
        $skip = new Skip;
        $skip->id = $id;
        $skip->save();
        return redirect('admin/skips');
    }

    public function block()
    {
        $students = Block::leftJoin('students', 'blocks.id', '=', 'students.id')->get();
        return view('admin/block', [
            'page' => 'blocks',
            'pageExtends' => '',
            'students' => $students
        ]);
    }

    public function deleteBlock()
    {
        $id = request('id');
        Block::where('id', $id)->delete();
        return redirect('admin/blocks');
    }

    public function addBlock(Request $request)
    {
        $id = $request->input('id');
        $block = new Block;
        $block->id = $id;
        $block->save();
        return redirect('admin/blocks');
    }

    public function notification()
    {
        $notifications = Notification::all();
        return view('admin/notification', [
            'page' => 'notifications',
            'pageExtends' => 'list-notifications',
            'notifications' => $notifications
        ]);
    }

    public function deleteNotification()
    {
        $id = request('id');
        Notification::where('id', $id)->delete();
        return redirect('admin/notifications');
    }

    public function addNotification()
    {
        return view('admin/addNotification', [
            'page' => 'notifications',
            'pageExtends' => 'add-notification'
        ]);
    }

    public function createNotification(Request $request)
    {
        $type = $request->input('type');
        $position = $request->input('position');
        $order = $request->input('order');
        $content = $request->input('content');

        $notification = new Notification;
        $notification->type = $type;
        $notification->position = $position;
        $notification->order = $order;
        $notification->content = $content;

        $notification->save();

        return redirect('admin/notifications');
    }
}
