@extends('admin.layouts.admin')
@section('title')
    edit users
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ویراش کاربر {{$user->name}}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.users.update',['user'=>$user->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control"  name="name" type="text" value="{{$user->name}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">شماره تلفن</label>
                        <input class="form-control"  name="cellphone" type="text" value="{{$user->cellphone}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="role">نقش کاربر</label>
                        <select  class="form-control" id="role" name="role">
                            <option></option>
                            @foreach($roles as $role)
                                <option value="{{$role->name}}"  {{in_array($role->id,$user->roles->pluck('id')->toArray())?'selected':''}}>{{$role->display_name}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="accordion col-md-12 mt-3" id="accordionPermission">
                        <div class="card">
                            <div class="card-header p-1" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-right" type="button" data-toggle="collapse" data-target="#collapsePermission" aria-expanded="true" aria-controls="collapseOne">
                                        مجوز های دسترسی
                                    </button>
                                </h2>
                            </div>

                            <div id="collapsePermission" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionPermission">
                                <div class="card-body row">
                                    @foreach($permissions as $permission)
                                        <div class="form-group form-check col-md-3">
                                            <input type="checkbox" class="form-check-input" id="permission_{{$permission->id}}"
                                                   name="{{$permission->name}}" value="{{$permission->name}}"
                                                {{in_array($permission->id,$user->permissions->pluck('id')->toArray())?'checked':''}}
                                                {{in_array($permission->id,$userPermission->pluck('id')->toArray())?'checked':''}}
                                            >
                                            <label class="form-check-label mr-3" for="permission_{{$permission->id}}">{{$permission->display_name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>


@endsection
