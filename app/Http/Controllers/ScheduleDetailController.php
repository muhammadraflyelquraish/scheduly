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
            ->where('schedule_id', $request->schedule_id)
            ->where('day', $request->day)
            ->get();

        $listSchedules = [
            ['start_time' => '07:30', 'end_time' => '10:00'],
            ['start_time' => '10:05', 'end_time' => '12:35'],
            ['start_time' => '10:15', 'end_time' => '12:45'],
            ['start_time' => '13:00', 'end_time' => '15:30'],
        ];

        $recomendationSchedule = [];
        $removedSchedule = [];
        foreach ($scheduleDetail as $value) {
            if (
                ($request->start_time . ':00' <= $value->end_time && $request->start_time . ':00' >= $value->start_time) ||
                ($request->end_time . ':00' <= $value->end_time && $request->end_time . ':00' >= $value->start_time)
            ) {

                foreach ($listSchedules as $schedule) {
                    $isRecom = false;

                    foreach ($scheduleDetail as $row) {
                        if (
                            ($schedule['start_time'] . ':00' <= $row->end_time && $schedule['start_time'] . ':00' >= $row->start_time) ||
                            ($schedule['end_time'] . ':00' <= $row->end_time && $schedule['end_time'] . ':00' >= $row->start_time)
                        ) {
                            array_push($removedSchedule, $schedule);
                            break;
                        } else {
                            $isRecom = true;
                        }
                    }

                    if ($isRecom) {
                        array_push($recomendationSchedule, $schedule);
                    }
                }

                foreach ($removedSchedule as $sec) {
                    $startTime = $sec['start_time'];
                    $recomendationSchedule = array_filter($recomendationSchedule, function ($sce) use ($startTime) {
                        return $sce['start_time'] !== $startTime;
                    });
                }
                $recomendationSchedule = array_values($recomendationSchedule);

                return redirect()
                    ->back()
                    ->with('failed', 'Jadwal sudah tersedia')
                    ->with('recomendation', $recomendationSchedule)
                    ->withInput();
            }
        }

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
