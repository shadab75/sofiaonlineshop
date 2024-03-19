<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::latest()->paginate(20);
        return view('admin.users.index',compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        $userPermission = $user->getPermissionsViaRoles();
        $permissions = Permission::all();
        $roles = Role::all();
        return view('admin.users.edit',compact('user','roles','permissions','userPermission'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {


        //
        $request->validate([
            'cellphone'=>'required|iran_mobile'
        ]);
        try {
            DB::beginTransaction();
        $user->update([
            'name'=>$request->name,
            'cellphone'=>$request->cellphone
        ]);
          $user->syncRoles($request->role);
            $permissions = $request->except('_token','cellphone','name','_method','role');
            $user->syncPermissions($permissions);
            DB::commit();
        }catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ویرایش نقش','خطای سیستمی')->persistent('حله');
            return redirect()->back();
        }
        alert()->success('کاربر با موفقیت ویرایش شد', 'باتشکر');
        return redirect()->route('admin.users.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
