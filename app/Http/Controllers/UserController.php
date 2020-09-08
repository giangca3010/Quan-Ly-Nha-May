<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\InforUser;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $name = 'Nhân Viên';
        $action = 'Danh Sách';
        $userList = User::join('info_user', 'users.id', '=', 'info_user.user_id')->get();
        return view('admin.user.list-user',compact('name','action','userList'));
    }

    public function create()
    {
    	$name = 'Nhân Viên';
        $action = 'Thêm';
        $permission = Permission::all();
        $role = Role::all();

    	return view('admin.user.create-user',compact('name','action','permission','role'));
    }

    public function store(Request $request)
    {
		$this->validate($request,[
    		'name'=>'required|min:6',
            'cmt' => 'required',
            'username' => 'required',
    		'password'=>'required|min:6|max:32',
    		'passwordAgain'=>'required|same:password'

    	],[
    		'name.required'=>'Bạn chưa nhập tên người dùng',
            'cmt.required'=>'Bạn chưa nhập chứng minh thư',
            'username.required'=>'Bạn chưa nhập username',
    		'name.min'=>'Tên quá ngắn,nó phải có ít nhất 6 ký tự',
    		'password.required'=>'Bạn chưa nhập mật khẩu',
    		'password.min'=>'Mật khẩu phải có ít nhất 6 ký tự',
    		'password.max'=>'Mật khẩu phải có tối đa 32 ký tự',
    		'passwordAgain.required'=>'Mật chưa nhập lại mật khẩu',
    		'passwordAgain.same'=>'Mật khẩu chưa trùng khớp'
    	]);
    	$user  = new User;
    	$user->name= $request->name;
    	$user ->email= $request->email;
        $user->username= $request->username;
    	$user ->password= bcrypt($request->password);
    	$user->save();

        $info = new InforUser;
        $info->user_id = $user->id;
        $info->cmt = $request->cmt;
        $info->date_cmt = date('Y-m-d',strtotime($request->ngaycap));
        $info->address_cmt = $request->noicap;
        $info->birthday = date('Y-m-d',strtotime($request->birth));
        $info->sex = $request->sex;
        $info->avatar = '/img/avatar5.png';
        $info->dan_toc = $request->dantoc;
        $info->start_work = date('Y-m-d',strtotime($request->start));
        $info->end_work = date('Y-m-d',strtotime($request->end));
        $info->address_now = $request->dcnow;
        $info->address_tt = $request->dctt;
        $info->save();

        $user->assignRole($request->input('roles'));
        $user->givePermissionTo($request->input('permission'));
	    return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công'
        ], 200);
    }

    public function edit($id)
    {
        $name = 'Nhân Viên';
        $action = 'Sửa';
        $user = User::where('users.id',$id)->join('info_user', 'users.id', '=', 'info_user.user_id')->first();
        // dd($user);
        $user_per = User::find($id);
        $selected_p = $user_per->getPermissionNames()->toArray();
        $roles = Role::all();
        $userRole = $user_per->roles->pluck('name','id')->first();
        // dd($userRole);
        $permission = Permission::all();
        return view('admin.user.edit-user',compact('name','action','user','roles','userRole','permission','id','selected_p'));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|min:6',
            'cmt' => 'required',
            'username' => 'required',
        ],[
            'name.required'=>'Bạn chưa nhập tên người dùng',
            'cmt.required'=>'Bạn chưa nhập chứng minh thư',
            'username.required'=>'Bạn chưa nhập username',
            'name.min'=>'Tên quá ngắn,nó phải có ít nhất 6 ký tự',
        ]);
        $user  = User::find($request->id);
        $user->revokePermissionTo($user->getAllPermissions());
        $user->name= $request->name;
        $user->email= $request->email;
        $user->username= $request->username;
        if ($request->password != null) {
            $user->password= bcrypt($request->password);
        }
        $user->save();

        $info = InforUser::where('user_id',$request->id)->first();
        $info->cmt = $request->cmt;
        $info->date_cmt = date('Y-m-d',strtotime($request->ngaycap));
        $info->address_cmt = $request->noicap;
        $info->birthday = date('Y-m-d',strtotime($request->birth));
        $info->sex = $request->sex;
        $info->dan_toc = $request->dantoc;
        $info->start_work = date('Y-m-d',strtotime($request->start));
        $info->end_work = date('Y-m-d',strtotime($request->end));
        $info->address_now = $request->dcnow;
        $info->address_tt = $request->dctt;
        $info->save();

        $user->assignRole($request->input('roles'));
        $user->givePermissionTo($request->input('permission'));
        return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công'
        ], 200);
    }

    public function profile($id,$username)
    {
        $info = User::where('users.id',$id)->where('username',$username)->join('info_user', 'users.id', '=', 'info_user.user_id')->first();
        $name = $info['name'];
        $action = 'Chỉnh Sửa Thông Tin';

        return view('admin.user.edit-profile',compact('name','action','info'));
    }

    public function postprofile(Request $request)
    {
        if ($request->password) {
            $this->validate($request,[
                'password'=>'min:6|max:32',
                'passwordAgain'=>'same:password'

            ],[
                'password.min'=>'Mật khẩu phải có ít nhất 6 ký tự',
                'password.max'=>'Mật khẩu phải có tối đa 32 ký tự',
                'passwordAgain.same'=>'Mật khẩu chưa trùng khớp'
            ]);
            $user  = User::find($request->id);
            $user->password= bcrypt($request->password);
            $user->save();
        }
        if($request->now){
            $info = InforUser::where('user_id',$request->id)->first();
            $info->address_now = $request->now;
            $info->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'Sửa Thành Công'
        ], 200);
    }

    public function avatar(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'select_file' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validation->passes()) {
            $file = $request->file('select_file');
            $new_name = rand().'.'.$file->getClientOriginalExtension();
            Storage::disk('public_uploads')->putFileAs('images', $file, $new_name);
            $info = InforUser::where('user_id',$request->id)->first();
            $info->avatar = '/storage/images/'.$new_name;
            $info->save();
            return response()->json([
                'message' => 'Thay ảnh đại diện thành công, muốn thay lại thì load lại trang',
                'uploaded_image' => '<img src="/storage/images/'.$new_name.'" class="profile-user-img img-responsive img-circle" style="cursor: pointer"/>',
                'class_name' => 'alert-success'
            ]);
        } else {
            return response()->json([
                'message' => $validation->errors()->all(),
                'uploaded_image' => '',
                'class_name' => 'alert-danger'
            ]);
        }
    }
}
