<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\nganh;
use App\khoa;
use Illuminate\Support\Facades\Validator;

class nganhController extends Controller
{
    public function getDataNganh()
    {
    	$gnganh = DB::table('nganhs')
                ->Join('khoas', 'khoas.MaKhoa', '=', 'nganhs.Khoas_MaKhoa')
                ->select('*')
                ->get();
        return view('nganh.get-nganh', ['gnganh' => $gnganh]);
    }
    public function show($id){

    }
   
    public function store(Request $request)
    {
        $rules = [
            'MaNganh' =>'required|min:2|string|',
            'TenNganh' => 'required|string|',
            'Khoas_MaKhoa' => 'required|',
        ];
        $messages = [
            'MaNganh.required' => 'Mã Ngành là trường bắt buộc',
            'TenNganh.required' => 'Tên Ngành là trường bắt buộc',
            'Khoas_MaKhoa.required' => 'Thuộc Khoa là trường bắt buộc',
            'MaNganh.min' => 'Mã khoa 2 kí tự trở lên',
            'TenNganh.string' => 'Tên Khoa phải là kí tự',
            'MaNganh.string' => 'Mã Khoa phải là kí tự',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else{
            if(nganh::where('MaNganh', $request->MaNganh)->count() == 0){
                $nganh = nganh::create($request->all());
                return redirect('/nganh/list')->with('success', 'Thêm dữ liệu thành công.');
            }
            else
                return back()->withErrors('Ngành học '.$request->MaNganh.' đã tồn tại.');
        }

        
    }

    public function edit($maNganh)
    {
        $khoas = khoa::all();
        $nganh = DB::table('nganhs')
                ->where('MaNganh', $maNganh)
                ->join('khoas', 'khoas.MaKhoa', '=', 'nganhs.Khoas_MaKhoa')
                ->first();
        return view('nganh.edit-nganh', compact('khoas','nganh'))->with('MaNganh', $maNganh);
    }
    public function update(Request $request){
        $rules = [
            'MaNganh' =>'required|min:2|string|',
            'TenNganh' => 'required|string|',
            'Khoas_MaKhoa' => 'required|',
        ];
        $messages = [
            'MaNganh.required' => 'Mã Ngành là trường bắt buộc',
            'TenNganh.required' => 'Tên Ngành là trường bắt buộc',
            'Khoas_MaKhoa.required' => 'Thuộc Khoa là trường bắt buộc',
            'MaNganh.min' => 'Mã khoa 2 kí tự trở lên',
            'TenNganh.string' => 'Tên Khoa phải là kí tự',
            'MaNganh.string' => 'Mã Khoa phải là kí tự',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else{
            if(nganh::where('MaNganh', $request->MaNganh)->count() == 0){
                return back()->withErrors('Mã ngành không hợp lệ, cập nhật lỗi');
            }
            else{
                DB::table('nganhs')->where('MaNganh', $request->MaNganh)->update(['TenNganh' => $request->TenNganh, 'Khoas_MaKhoa'=> $request->Khoas_MaKhoa]);
                return redirect('nganh/list')->with('success', 'Sửa dữ liệu thành công.');
            }
        }
    }
    public function delete(Request $request)
    {
        DB::table('nganhs')
            ->where('MaNganh', $request->MaNganh)
            ->delete();
        return back()->with('remove', 'Xóa dữ liệu thành công.');
    }
    public function getAjaxN($maKhoa)
    {
        $ajnganh = DB::table('nganhs')
                    ->where('Khoas_MaKhoa',"LIKE", $maKhoa)
                    ->join('khoas', 'khoas.MaKhoa', '=', 'nganhs.Khoas_MaKhoa')
                    ->get();
        return $ajnganh;
    }
}
