<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //
    public function create()
    {
        //
        return view('admin.permissions.create');
    }
    public function index()
    {
        //
        $permissions = Permission::latest()->paginate(20);
        return view('admin.permissions.index',compact('permissions'));
    }
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required',
            'display_name'=>'required',

        ]);
        Permission::query()->create([
            'name'=>$request->name,
            'display_name'=>$request->display_name,
            'guard_name'=>'web'
        ]);
        alert()->success('مجوز مورد نظر شما ایجاد شد', 'باتشکر');
        return redirect()->route('admin.permissions.index');
    }
    public function edit(Permission $permission)
    {
        //
        return view('admin.permissions.edit',compact('permission'));
    }
    public function update(Request $request, Permission $permission)
    {
        //
        $request->validate([
            'name'=>'required|unique:permissions,name,'.$permission->id,
            'display_name'=>'required|unique:permissions,display_name,'.$permission->id
        ]);
        $permission->update([
            'name'=>$request->name,
            'display_name'=>$request->display_name
        ]);
        alert()->success('مجوز مورد نظر  شما با موفقیت ویرایش شد', 'باتشکر');
        return redirect()->route('admin.permissions.index');

    }
}
