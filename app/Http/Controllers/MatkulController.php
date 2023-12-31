<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Matkul;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class MatkulController extends Controller
{
    function index(): View
    {
        $last_matkul = Matkul::latest()->first();
        $code = $last_matkul ? sprintf('101838%03s', substr($last_matkul->code, 6) + 1) : '101838001';

        return view('matkul.index', compact('code'));
    }

    function create(): JsonResponse
    {
        $matkul = Matkul::query();
        return DataTables::of($matkul)
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
            Matkul::create($request->all());
            return response()->json(['res' => 'success', 'msg' => 'Data berhasil ditambahkan'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    function show($id)
    {
        return Matkul::findOrFail($id);
    }

    function update(Request $request, $id): JsonResponse
    {
        try {
            Matkul::findOrFail($id)->update($request->all());
            return response()->json(['res' => 'success', 'msg' => 'Data berhasil diubah'], Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    function destroy($id): JsonResponse
    {
        try {
            Matkul::findOrFail($id)->delete();
            return response()->json(['res' => 'success'], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
