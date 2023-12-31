<?php

namespace App\Http\Controllers;

use App\Models\ScheduleMatkulClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScheduleMatkulClassController extends Controller
{
    function store(Request $request)
    {
        $scheduleMatkulClass = ScheduleMatkulClass::query()
            ->where('schedule_matkul_id', $request->schedule_matkul_id)
            ->where('class_id', $request->class_id,)
            ->first();

        if (!$scheduleMatkulClass) {
            ScheduleMatkulClass::create([
                'schedule_matkul_id' => $request->schedule_matkul_id,
                'class_id' => $request->class_id,
                'sks' => $request->sks,
                'day' => $request->day,
                'hour' => $request->start_time . ' s.d ' . $request->end_time,
                'room' => $request->room
            ]);
        }

        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan');
    }

    function destroy($id): JsonResponse
    {
        try {
            ScheduleMatkulClass::findOrFail($id)->delete();
            return response()->json(['res' => 'success'], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
