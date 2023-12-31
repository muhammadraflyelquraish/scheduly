<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Classes;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;


class ClassesController extends Controller
{
    function index(): View
    {
        return view('class.index');
    }

    function create(): JsonResponse
    {
        $class = Classes::query();
        return DataTables::of($class)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return parent::_getActionButton($row->id);
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    function store(Request $request): JsonResponse
    {
        try {
            Classes::create($request->all());
            return response()->json(['res' => 'success', 'msg' => 'Data berhasil ditambahkan'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    function show($id)
    {
        return Classes::findOrFail($id);
    }

    function update(Request $request, $id): JsonResponse
    {
        try {
            Classes::findOrFail($id)->update($request->all());
            return response()->json(['res' => 'success', 'msg' => 'Data berhasil diubah'], Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    function destroy($id): JsonResponse
    {
        try {
            Classes::findOrFail($id)->delete();
            return response()->json(['res' => 'success'], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
