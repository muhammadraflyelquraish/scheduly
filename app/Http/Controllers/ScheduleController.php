<?php

namespace App\Http\Controllers;

use App\Exports\ScheduleExport;
use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ScheduleController extends Controller
{
    function index(): View
    {
        return view('schedule.index');
    }

    function data(): JsonResponse
    {
        $schedule = Schedule::with('user');
        if (auth()->user()->role->name == 'Dosen') {
            $schedule->where('user_id', auth()->user()->id);
        }

        $schedule->when(request('dosen'), function ($query) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', "%" . request('dosen') . "%");
                $q->orWhere('email', 'like', "%" . request('dosen') . "%");
                $q->orWhere('nip', 'like', "%" . request('dosen') . "%");
            });
        });

        $schedule->when(request('academic_year'), function ($query) {
            $query->where('academic_year', request('academic_year'));
        });

        $schedule->when(request('type_periode'), function ($query) {
            $query->where('type_periode', request('type_periode'));
        });

        return DataTables::of($schedule)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '<div class="btn-group pull-right">';
                $button .= '<button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#downloadModal"><i class="fa fa-download"></i></button>';
                $button .= '<a class="btn btn-sm btn-success" href="' . route('schedule.show', $row->id) . '"><i class="fa fa-eye"></i></a>';
                if (auth()->user()->role->name == 'Admin' || auth()->user()->role->name == 'Staff') {
                    $button .= '<a class="btn btn-sm btn-warning" href="' . route('schedule.edit', $row->id) . '"><i class="fa fa-edit"></i></a>';
                    $button .= '<button class="btn btn-sm btn-danger" id="delete" data-integrity="' . $row->id . '"><i class="fa fa-trash"></i></button>';
                }
                $button .= '</div>';
                return $button;
            })
            ->editColumn('user.name', function ($row) {
                return '<input type="hidden" id="userId" value="' . $row->user->id . '">' . $row->user->name . "<br>" . '<small> NIP. ' . $row->user->nip . '</small>';
            })
            ->editColumn('academic_year', function ($row) {
                return $row->academic_year . ' ' . $row->type_periode;
            })
            ->rawColumns(['action', 'user.name', 'academic_year'])
            ->toJson();
    }

    function create()
    {
        $dosen = User::with('role')
            ->whereHas('role', function ($q) {
                $q->where('name', "Dosen");
            })
            ->get();

        return view('schedule.create', compact('dosen'));
    }

    function store(Request $request)
    {
        try {
            $existSchedule = Schedule::query()
                ->where('user_id', $request->user_id)
                ->where('academic_year', $request->academic_year)
                ->where('type_periode', $request->type_periode)
                ->first();

            if ($existSchedule) {
                return redirect()->back()->with('failed', 'Jadwal sudah ada');
            }

            Schedule::create($request->all());

            return redirect()->route('schedule.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('schedule.index')->with('failed', 'Data gagal ditambahkan');
        }
    }

    function show(Schedule $schedule)
    {
        $schedule = $schedule
            ->load('user')
            ->load('detail');

        return view('schedule.detail', compact('schedule'));
    }

    function edit(Schedule $schedule)
    {
        $dosen = User::with('role')
            ->whereHas('role', function ($q) {
                $q->where('name', "Dosen");
            })
            ->get();

        $schedule = $schedule;

        return view('schedule.edit', compact('dosen', 'schedule'));
    }

    function update(Request $request, $id)
    {
        try {
            $existSchedule = Schedule::query()
                ->where('id', '!=', $id)
                ->where('user_id', $request->user_id)
                ->where('academic_year', $request->academic_year)
                ->where('type_periode', $request->type_periode)
                ->first();

            if ($existSchedule) {
                return redirect()->back()->with('failed', 'Jadwal sudah ada');
            }

            Schedule::findOrFail($id)->update($request->all());

            return redirect()->route('schedule.index')->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->route('schedule.index')->with('failed', 'Data gagal diubah');
        }
    }

    function destroy($id): JsonResponse
    {
        try {
            $sec = Schedule::find($id)->delete();
            return response()->json(['res' => 'success'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function export(Request $request)
    {
        $time = date('dMY-His');
        return Excel::download(new ScheduleExport($request), 'schedule-' . $time . '.xlsx');
    }
}
