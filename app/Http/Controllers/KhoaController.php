<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\khoa;
use Illuminate\Support\Facades\Validator;

class KhoaController extends Controller
{
    public function getTenKhoa(){
        $variable  = DB::table('khoas')->select('khoas.*')->groupBy('MaNganh')->get();
        return view('nganh.create-nganh', ['variable ' => $variable ]);
    }
    public function index()
    {
        //
    }
    public function create()
    {
        return view('khoa.create-khoa');
    }
    public function getDataKhoa(){
        $petani = DB::table('khoas')->get(); 
        return view('khoa.get-khoa', ['petani' => $petani]);
    }
    public function store(Request $request)
    {

        $rules = [
            'MaKhoa' =>'required|min:2|string|',
            'TenKhoa' => 'required|string|',
        ];
        $messages = [
            'MaKhoa.required' => 'Mã Khoa là trường bắt buộc',
            'TenKhoa.required' => 'Tên Khoa là trường bắt buộc',
            'MaKhoa.min' => 'Mã khoa 2 kí tự trở lên',
            'TenKhoa.string' => 'Tên Khoa phải là kí tự',
            'MaKhoa.string' => 'Mã Khoa phải là kí tự',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect('/khoa/create')->withErrors($validator)->withInput();
        }
        else{
        /*$khoa = new Khoa([
            'MaKhoa' => $request->get('MaKhoa'),
            'TenKhoa' => $request->get('TenKhoa'),
        ]);*/

            $MaKhoa = $request->MaKhoa;
            $TenKhoa = $request->TenKhoa;
            if(Khoa::where('MaKhoa', $MaKhoa)->count() == 0){  
                $khoa = new Khoa;
                $khoa->Makhoa = $MaKhoa;
                $khoa->TenKhoa = $TenKhoa;
                $khoa->save();
                return redirect('/khoa/list')->with('success', 'Thêm dữ liệu thành công.');//
            }
            else{
                return redirect('/khoa/list')->withErrors('Mã Khoa -'.$MaKhoa.'- đã tồn tại.');//
            }
        }
    }
    public function edit($maKhoa)
    {
        $khoa = DB::table('khoas')->where('MaKhoa', $maKhoa)->first();
        return view('khoa.edit-khoa', compact('khoa'))->with('MaKhoa', $maKhoa);
    }
    public function update(Request $request){
        $rules = [
            'MaKhoa' =>'required|min:2|string|',
            'TenKhoa' => 'required|string|',
        ];
        $messages = [
            'MaKhoa.required' => 'Mã Khoa là trường bắt buộc',
            'TenKhoa.required' => 'Tên Khoa là trường bắt buộc',
            'MaKhoa.min' => 'Mã khoa 2 kí tự trở lên',
            'TenKhoa.string' => 'Tên Khoa phải là kí tự',
            'MaKhoa.string' => 'Mã Khoa phải là kí tự',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else{
            if(khoa::where('MaKhoa', $request->MaKhoa)->count() == 0){
                return back()->withErrors('Mã Khoa không hợp lệ, cập nhật thất bại');
            }
            else{
                DB::table('khoas')->where('MaKhoa', $request->MaKhoa)->update(['TenKhoa' => $request->TenKhoa]);
                return redirect('khoa/list')->with('success', 'Cập nhật dữ liệu thành công.');
            }
        }
    }
    public function delete(Request $request)
    {
        DB::table('khoas')->where('MaKhoa', $request->MaKhoa)->delete();
        return back()->with('remove', 'Xóa dữ liệu thành công.');
    }

    function fetch(Request $request){
        $select = $request->get('select'); //Makhoa
        $value = $request->get('value'); //Makhoa--
        $dependent = $request->get('dependent'); //MaNganh
        $data = DB::table('nganhs')
                ->where('Khoas_MaKhoa', $value)
                ->get();
        $output = '<option value="">Chọn ngành</option>';
        foreach ($data as $row) {
           $output .= '<option value="'.$row->MaNganh.'">'.$row->TenNganh.'</option>';
        }
        echo $output;
    }
    
}
