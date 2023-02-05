<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\Roles\StoreRequest;
use App\Http\Requests\Backend\Roles\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role_list|role_create|role_edit|role_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:role_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role_delete', ['only' => ['destroy']]);
        $this->middleware('permission:trashed_roles', ['only' => ['trashedRoles', 'restore', 'hardDelete']]);
    }

    public function index()
    {
        $roles = Role::get();
        return DataTables::of($roles)
            ->addColumn('created', function ($role) {
                return $role->created_at->format('d F Y');
            })
            ->addColumn('name', function ($role) {
                return $role->name;
            })
            ->addColumn('action', function ($role) {
                return (auth()->user()->can('role_edit') ? $role->name == "super-admin" ? "" : '<span class="action-edit btn btn-link btn-sm text-dark" data-id="' . $role->id . '" data-target="#edit-user-modal"><i class="far fa-edit"></i> Edit</span>' : '')
                    . (auth()->user()->can('role_delete') ? $role->name == "super-admin" ? "" : '<span class="action-role-delete btn btn-link btn-sm text-danger btn-sm" data-toggle="modal" data-target="#role-modal" data-id="' . $role->id . '"><i class="far fa-trash-alt"></i> Delete</span>' : '');
            })
            ->rawColumns(['created', 'name', 'action'])
            ->make(true);
    }

    public function show()
    {
        $roles = Role::latest()->get();

        return response()->json([
            "message" => $roles
        ]);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create(['name'=>$request->name]);
            $role->syncPermissions($request->permissions);

            DB::commit();

            return response()->json([
                'message' => $role->name . " successfully created."
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {

            $role = Role::findById($request->id);

            if ($role->users->first() != null) {
                return response()->json([
                    'message' => $role->name . " role cannot be delete"
                ], 401);
            }

            $role->delete();
            DB::commit();
            return response()->json([
                'message' => $role->name . " successfully deleted."
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        $role = Role::find($id);

        $rolePermissions = $role->permissions()->get()->pluck('id')->toArray();

        return response()->json([
            'role' => $role,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $role = Role::where('id', $id)->first();
            $role->name = $request->name;
            $role->save();

            $role->syncPermissions($request->permissions);

            DB::commit();

            return response()->json([
                "message" => $role->name . " successfully updated.",
                'role' => $role
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function trashedRoles()
    {
        $roles = Role::onlyTrashed()->get();

        return DataTables::of($roles)
            ->addColumn('created', function ($role) {
                return $role->created_at->format('d F Y');
            })
            ->addColumn('name', function ($role) {
                return $role->name;
            })
            ->addColumn('action', function ($role) {
                return (auth()->user()->can('trashed_roles') ? $role->name == "super-admin" ? "" : '<span class="action-restore btn btn-link btn-sm text-dark" data-id="' . $role->id . '"><i class="far fa-edit"></i> Restore</span>' : '')
                    . (auth()->user()->can('trashed_roles') ? $role->name == "super-admin" ? "" : '<span class="action-role-delete btn btn-link btn-sm text-danger btn-sm" data-toggle="modal" data-target="#role-modal" data-id="' . $role->id . '" data-name="' . $role->name . '"><i class="far fa-trash-alt"></i> Delete Permanently</span>' : '');
            })
            ->rawColumns(['created', 'name', 'action'])
            ->make(true);
    }

    public function restore($id)
    {
        DB::beginTransaction();
        try {

            $role = Role::onlyTrashed()->whereId($id)->firstOrFail();
            $role->restore();

            DB::commit();
            return response()->json([
                'message' => 'Role successfully restored.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function hardDelete($id)
    {
        DB::beginTransaction();
        try {

            $role = Role::withTrashed()->whereId($id)->firstOrFail();
            $role->forceDelete();

            DB::commit();
            return response()->json([
                'message' => 'Role permanently deleted.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
