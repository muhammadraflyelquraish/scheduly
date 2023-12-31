<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

use App\Models\User;
use Yajra\DataTables\DataTables;


class UserController extends Controller
{

    public function index(): View
    {
        $roles = Role::get();
        return view('user.index', compact('roles'));
    }

    public function create(): JsonResponse
    {
        $user = User::with('role')->whereNotIn('id', array(auth()->user()->id));

        return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return parent::_getActionButton($row->id);
            })
            ->editColumn('role.name', function($row){
                return '<input type="hidden" id="roleId" value="'.$row->role->id.'">' . $row->role->name;
            })
            ->rawColumns(['action', 'role.name'])
            ->toJson();
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        try {
            $user = User::create($data);
            return response()->json(['res' => 'success', 'msg' => 'Data berhasil ditambahkan'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            User::findOrFail($id)->update($request->all());
            return response()->json(['res' => 'success', 'msg' => 'Data berhasil diubah'], Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            User::findOrFail($id)->delete();
            return response()->json(['res' => 'success'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['res' => 'error', 'msg' => $e->getMessage()], Response::HTTP_CONFLICT);
        }
    }
}
