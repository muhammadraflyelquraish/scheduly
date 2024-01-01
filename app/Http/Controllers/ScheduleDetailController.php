<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Matkul;
use App\Models\ScheduleDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScheduleDetailController extends Controller
{
    function create(Request $request)
    {
        $scheduleId = $request->query('scheduleId');
        $matkul = Matkul::get();
        $class = Classes::get();

        $last_schedule = ScheduleDetail::latest()->first();
        $code = $last_schedule ? sprintf('FST6094%03s', substr($last_schedule->code, 6) + 1) : 'FST6094001';

        return view('schedule.detail-create', compact('scheduleId', 'matkul', 'class', 'code'));
    }

    function store(Request $request)
    {
        $scheduleDetail = ScheduleDetail::query()
            // ->where('schedule_id', $request->schedule_id)
            // ->where('day', $request->day)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time . ':00', $request->end_time . ':00'])
                    ->orWhereBetween('end_time', [$request->start_time . ':00', $request->end_time . ':00']);
            })
            ->first();

        // dd($request->all(), $scheduleDetail, $request->start_time . ':00', $request->end_time . ':00');

        // if ($scheduleDetail) {
        //     return redirect()->back()->with('failed', 'Jadwal sudah ada');
        // }

        ScheduleDetail::create([
            'schedule_id' => $request->schedule_id,
            'code' => $request->code,
            'matkul_id' => $request->matkul_id,
            'class_id' => $request->class_id,
            'sks' => $request->sks,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'room' => $request->room,
        ]);

        return redirect()->route('schedule.show', $request->schedule_id)->with('success', 'Jadwal berhasil ditambahkan');
    }

    function destroy($id): JsonResponse
    {
        try {
            ScheduleDetail::findOrFail($id)->delete();
            return response()->json(['res' => 'success'], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
