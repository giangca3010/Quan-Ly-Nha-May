<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $name = 'Bộ Phận';
        $action = 'Danh Sách';
        $roleList = Role::latest()->get();
        // $permission = Permission::all()->get();
        // dd($permission);

        return view('admin.role.list-role',compact('name','action','roleList'));
    }

    public function create()
    {
    	$name = 'Bộ Phận';
        $action = 'Thêm';
        $permission = Permission::all();
        $role = Role::all();

    	return view('admin.role.create-role',compact('name','action','permission','role'));
    }

    public function store(Request $request)
    {
		$this->validate($request,[
    		'name' => 'required|unique:roles,name',
            'permission' => 'required',
    	],[
    		'name.required'=>'Bạn chưa nhập tên bộ phận',
    		'name.unique'=>'Bạn nhập tên đã trùng',
    		'permission.required'=>'Bạn chưa chọn quyền',
    	]);

    	$role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return response()->json([
            'status' => true,
            'message' => 'Cập Nhật Thành Công'
        ], 200);
	
    }

    public function edit($id)
    {
        $name = 'Bộ Phận';
        $action = 'Sửa';
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = \DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

// dd($rolePermissions);
        return view('admin.role.edit-role',compact('role','permission','rolePermissions','name','action'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($request->input('id'));
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return response()->json([
            'status' => true,
            'message' => 'Cập Nhật Thành Công'
        ], 200);
    }
}
