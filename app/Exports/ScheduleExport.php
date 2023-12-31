<?php

namespace App\Exports;

use App\Models\Schedule;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ScheduleExport implements FromView
{

    public function view(): View
    {
        $schedules = Schedule::with('user', 'detail');

        return view('exports.schedule', [
            'schedules' => $schedules->get()
        ]);
    }
}
