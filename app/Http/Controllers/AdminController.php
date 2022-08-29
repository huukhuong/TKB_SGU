<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Config;
use App\Models\Lecture;
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
            'students' => $students
        ]);
    }

    public function lecture()
    {
        $lectures = Lecture::orderBy('created_at', 'ASC')->paginate(100);
        return view('admin/lecture', [
            'page' => 'lectures',
            'lectures' => $lectures
        ]);
    }

    public function addLecture(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        Lecture::insert([
            'id' => $id,
            'name' => $name
        ]);
        return redirect('admin/lectures');
    }

    public function skip()
    {
        $students = Skip::leftJoin('students', 'skips.id', '=', 'students.id')->get();
        return view('admin/skip', [
            'page' => 'skip',
            'students' => $students
        ]);
    }
}
