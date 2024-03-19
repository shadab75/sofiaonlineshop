<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        //
        $roles = Role::latest()->paginate(20);
        return view('admin.roles.index',compact('roles'));
    }
    //
    public function create()
    {
        //
        $permissions = Permission::all();
        return view('admin.roles.create',compact('permissions'));
    }
    public function store(Request $request)
    {
        //

        $request->validate([
            'name'=>'required',
            'display_name'=>'required',

        ]);
        try {
            DB::beginTransaction();
        $role =  Role::query()->create([
            'name'=>$request->name,
            'display_name'=>$request->display_name,
            'guard_name'=>'web'
        ]);
        $permissions = $request->except('_token','display_name','name');

        $role->givePermissionTo($permissions);
            DB::commit();
        }catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ایجاد نقش', 'خطای سیستمی')->persistent('حله');
            return redirect()->back();
        }
        alert()->success('نقش مورد نظر شما ایجاد شد', 'باتشکر');
        return redirect()->route('admin.roles.index');
    }
    public function show(Role $role)
    {

        //
        return view('admin.roles.show',compact('role'));
    }
    public function edit(Role $role)
    {
        //

        $permissions = Permission::all();
        return view('admin.roles.edit',compact('role','permissions'));
    }
    public function update(Request $request ,Role $role)
    {

        $request->validate([
            'name'=>'required|unique:roles,name,'.$role->id,
            'display_name'=>'required|unique:roles,display_name,'.$role->id
        ]);
        try {
            DB::beginTransaction();
            $role->update([
                'name'=>$request->name,
                'display_name'=>$request->display_name,
            ]);
            $permissions = $request->except('_token','display_name','name','_method');
            $role->syncPermissions($permissions);
            DB::commit();
        }catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ویرایش نقش', 'باتشکر')->persistent('حله');
            return redirect()->back();
        }
        alert()->success('نقش مورد نظر شما ویرایش شد', 'باتشکر');
        return redirect()->route('admin.roles.index');
    }
}
