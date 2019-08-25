<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\dotxet;
use Illuminate\Support\Facades\DB;
use App\sinhvien;
use App\khoa;
use App\nganh;
use Illuminate\Support\Facades\Validator;


class dotxetController extends Controller
{
    public function getDataDotXet()
    {
    	$dotxet = DB::table('dotxets')->select('dotxets.*')->get();
        return view('Dotxet.get-dot', ['dotxet' => $dotxet]);
    }
    public function getStatus($maSV){
        $status = DB::table('sinhviens')->where('MaSV', 'like', '%'.$maSV.'%')->value('DotXets_MaDX');
        return response()->json($status);
    }
    public function store(Request $request)
    {
        $rules = [
            'MaDX' =>'required|unique:dotxets|numeric|between:1,4',
            'TenDX' => 'required|string',
            'NgayBatDau' => 'required',
            'NgayKetThuc' => 'required',
        ];
        $messages = [
            'MaDX.required' => 'Mã Đợt là trường bắt buộc',
            'TenDX.required' => 'Tên Đợt là trường bắt buộc',
            'NgayBatDau.required' => 'Ngày bắt đầu là trường bắt buộc',
            'NgayKetThuc.required' => 'Ngày kết thúc là trường bắt buộc',
            'MaDX.unique' => 'Mã đợt xét đã tồn tại',
            'MaDX.between' => 'Mã đợt nằm trong khoảng [1,4]',
            'MaDX.numeric' => 'Mã đợt phải là số',
            'TenDX.string' => 'Ten Đợt là chuỗi kí tự',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else{
            if(dotxet::count() >= 3){
                return redirect('/dotxet/list')->with('info', 'Đã vượt quá số lượng đợt xét đc cho phép');
            }
            else{
                if(dotxet::where('MaDX', $request->MaDX)->count() != 0)
                    return back()->withErrors('Mã đợt xét đã tồn tại');
                else{
                    $dotxet = dotxet::create($request->all());
                    return redirect('/dotxet/list')->with('success', 'Thêm dữ liệu thành công.');
                }
            }
        }
    }

    public function edit($maDX)
    {
        $dotxet = DB::table('dotxets')
                ->where('MaDX', $maDX)
                ->first();
        return view('Dotxet.edit-dot', compact('dotxet'))->with('MaDX', $maDX);
    }
    public function update(Request $request){
       $rules = [
            'MaDX' =>'required|unique:dotxets|numeric|between:1,4',
            'TenDX' => 'required|string',
            'NgayBatDau' => 'required',
            'NgayKetThuc' => 'required',
        ];
        $messages = [
            'MaDX.required' => 'Mã Đợt là trường bắt buộc',
            'TenDX.required' => 'Tên Đợt là trường bắt buộc',
            'NgayBatDau.required' => 'Ngày bắt đầu là trường bắt buộc',
            'NgayKetThuc.required' => 'Ngày kết thúc là trường bắt buộc',
            'MaDX.unique' => 'Mã đợt xét đã tồn tại',
            'MaDX.between' => 'Mã đợt nằm trong khoảng [1,4]',
            'MaDX.numeric' => 'Mã đợt phải là số',
            'TenDX.string' => 'Ten Đợt là chuỗi kí tự',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else{
            if(dotxet::where('MaDX', $request->MaDX)->count() == 0)
                return back()->withErrors('Mã đợt xét không hợp lệ');
            else{
                DB::table('dotxets')->where('MaDX', $request->MaDX)->update(['TenDX' => $request->TenDX, 'Status'=> $request->Status, 'NgayBatDau' => $request->NgayBatDau, 'NgayKetThuc'=> $request->NgayKetThuc]);
                return redirect('dotxet/list')->with('success', 'cập nhật dữ liệu đợt xét thành công.');
            }
        }

        

    }
    public function delete(Request $request)
    {
        DB::table('dotxets')->where('MaDX', $request->MaDX)->delete();
        return back()->with('remove', 'Xóa dữ liệu thành công.');
    }

    public function dangky(Request $request){
        $dangky = sinhvien::create();
        return redirect('/dotxet/list')->with('success', 'Thêm dữ liệu thành công.');
    }
    public function showStudent($mdx){
        $temp = DB::table('sinhviens')
                ->join('dotxets', 'dotxets.MaDX', '=', 'sinhviens.DotXets_MaDX')
                ->where('DotXets_MaDX','=', $mdx)
                ->join('nganhs','nganhs.MaNganh', '=', 'sinhviens.MaNganh')
                ->join('khoas','khoas.MaKhoa', '=', 'sinhviens.MaKhoa')
                ->get();
        return view('Dotxet.showData')->with('temp', $temp);

    }
}
