<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Matkul;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function index()
    {
        $totalSchedule = Schedule::count();
        $totalMatkul = Matkul::count();
        $totalClass = Classes::count();
        $totalDosen = User::where('role_id', 4)->count();
        return view('dashboard', compact('totalSchedule', 'totalMatkul', 'totalClass', 'totalDosen'));
    }

    function data()
    {
        $scheduleLabels = [];
        $totalSchedule = [];
        $totalUser = [];
        for ($i = date('Y') - 5; $i < date('Y') + 5; $i++) {
            array_push($scheduleLabels, strval($i) . "/" . strval($i + 1));
        }

        foreach ($scheduleLabels as $label) {
            $countSchedule = Schedule::query()
                ->where('academic_year', $label)
                ->count();

            array_push($totalSchedule, $countSchedule);
        }

        foreach ($scheduleLabels as $label) {
            $countSchedule = DB::table('schedules')
                ->distinct('user_id')
                ->where('academic_year', $label)
                ->count('user_id');

            array_push($totalUser, $countSchedule);
        }

        return response()->json([
            'scheduleLabels' => $scheduleLabels,
            'totalSchedule' => $totalSchedule,
            'totalUser' => $totalUser
        ]);
    }
}
