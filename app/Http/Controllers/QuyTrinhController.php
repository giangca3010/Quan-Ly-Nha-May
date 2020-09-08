<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\QuyTrinh;
use DB;
use Illuminate\Support\Facades\Storage;

class QuyTrinhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function quyTrinh()
    {
        $name = "Quy Trình";
        $action ="Danh Sách";
        $quytrinh = DB::table('quytrinh')->get();
        return view('admin.quyDinh.quyTrinh.quytrinh',compact('name','action','quytrinh'));
    }

    public function addQuyTrinh()
    {
        $name ="Quy Trình";
        $action = "Thêm";
        return view('admin.quyDinh.quyTrinh.add_quytrinh',compact('name','action'));
    }

    
    public function save_quy_trinh(Request $request)
    {
        // dd($request->all());
        if ($request->link != null) {//kiểm tra link có giá trị hay k
            $file = $request->link;
            // dd(is_file($file));
            if (is_file($file)) {//kiểm tra link là file hay là text, nếu là file thì chạy
                $new_name = rand().'.'.$file->getClientOriginalExtension();//đặt tên file
                Storage::disk('public_uploads')->putFileAs('quytrinh', $file, $new_name);//lưu file vào foder
                $folder = '/storage/quytrinh/'.$new_name;
            }
        }else{
            $folder=null;
        }

         DB::table('quytrinh')->insert([
            'ten_quy_trinh' =>$request->ten_quy_trinh,
            'kyhieu'=>$request->kyhieu,
            'link'=>$folder,
        ]);
        return redirect('/quyTrinh');
    }

    
    public function edit_quy_trinh( $id)
    {
        $name = "Quy Trình";
        $action ="Sửa";
        $editQuyTrinh = DB::table('quytrinh')
            ->where('id','=', $id)
            ->first()
        ;
        return view('admin.quyDinh.quyTrinh.editquytrinh', 
            ['editQuyTrinh'=>$editQuyTrinh, 'name'=>$name, 'action'=>$action]);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\quytrinh  $quytrinh
     * @return \Illuminate\Http\Response
     */
    public function update_quy_trinh(Request $request,$id)
    {
        $rawData = $request -> all();
        // dd($request->all());
        if ($rawData['link'] != null) {//kiểm tra link có giá trị hay k
            $file = $rawData['link'];
            // dd(is_file($file));
            if (is_file($file)) {//kiểm tra link là file hay là text, nếu là file thì chạy
                $new_name = rand().'.'.$file->getClientOriginalExtension();//đặt tên file
                Storage::disk('public_uploads')->putFileAs('quytrinh', $file, $new_name);//lưu file vào foder
                $folder = '/storage/quytrinh/'.$new_name;
            }
        }else{
            $folder=null;
        }
        
        $dataUpdate = [
            'ten_quy_trinh' => $rawData['ten_quy_trinh'],
            'kyhieu' => $rawData['kyhieu'],
            'link' => $folder,
        ];
        DB::table('quytrinh')
            ->where('id', '=', $id)
            ->update($dataUpdate)
        ;
        return redirect('/quyTrinh');
    }

    public function delete_quy_trinh($id)
    {

        DB::table('quytrinh')
            ->where('id',$id)->delete();

        return redirect('/quyTrinh');
    }
}
