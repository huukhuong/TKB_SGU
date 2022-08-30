<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Notification;
use Illuminate\Http\Request;

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
}
