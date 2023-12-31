<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ScheduleMatkul;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ScheduleMatkulController extends Controller
{
    function store(Request $request)
    {
        if ($request->matkul_ids) {
            DB::transaction(function () use ($request) {
                foreach ($request->matkul_ids as $matkul_id) {
                    $scheduleMatkul = ScheduleMatkul::query()
                        ->where('schedule_id', $request->schedule_id)
                        ->where('matkul_id', $matkul_id)
                        ->first();

                    if ($scheduleMatkul) {
                        continue;
                    }

                    ScheduleMatkul::create([
                        'schedule_id' => $request->schedule_id,
                        'matkul_id' => $matkul_id
                    ]);
                }
            });
        }

        return redirect()->back()->with('success', 'Matkul successfully added');
    }

    function show(ScheduleMatkul $scheduleMatkul)
    {
        $scheduleMatkul = $scheduleMatkul
            ->load('schedule')
            ->load('classes');

        $class = Classes::get();
        return view('schedule.class', compact('scheduleMatkul', 'class'));
    }

    function destroy($id): JsonResponse
    {
        try {
            ScheduleMatkul::findOrFail($id)->delete();
            return response()->json(['res' => 'success'], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
