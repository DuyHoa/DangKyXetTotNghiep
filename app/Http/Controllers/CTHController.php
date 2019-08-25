<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChuongTrinhHoc;
use Illuminate\Support\Facades\DB;


class CTHController extends Controller
{
    public function getDataChuongTrinh()
    {
    	$ChuongTrinhHoc = DB::table('chuong_trinh_hocs')->select('chuong_trinh_hocs.*')->get();
        return view('Chuongtrinh.getcth', ['ChuongTrinhHoc' => $ChuongTrinhHoc]);
    }

    public function getCTH($manganh){
        $cth = DB::table('chuong_trinh_hocs')->select('*')->where('Nganh', '=', $manganh)->orderby('MaMon','asc')->get();
        return $cth;
    }
    public function index(){
        return view('Chuongtrinh.setcth');
    }
    public function store(Request $request)
    {
        //$ChuongTrinhHoc = ChuongTrinhHoc::create($request->all());
        //return redirect()->back();
        if(ChuongTrinhHoc::where('MaMon', $request->MaMon)->where('Nganh', $request->Nganh)->where('khoa', $request->khoa)->where('khoas', $request->khoas)->count() == 0){
            $cth = new ChuongTrinhHoc;
            $cth->MaMon = $request->MaMon;
            $cth->TenMon = $request->TenMon;
            $cth->TinChi = DB::table('monhocs')->select('TinChi')->where("monhocs.MaMon", "=", $request->MaMon)->value('TinChi');
            $cth->Term = $request->Term;
            $cth->Nganh = $request->Nganh;
            $cth->khoa = $request->khoa;
            $cth->khoas = $request->khoas;
            $cth->save();
            return 'Đã thêm môn '.$request->MaMon.' thành công';
        }
        else{
            return 'Môn học '.$request->MaMon.' đã tồn tại';
        }
    }

    public function update(Request $request, ChuongTrinhHoc $ChuongTrinhHoc)
    {
        $ChuongTrinhHoc->update($request->all());

        return response()->json($ChuongTrinhHoc, 200);
    }

    public function delete(Request $request)
    {
        DB::table('chuong_trinh_hocs')->where('MaMon', $request->MaMon)->where('Term', $request->Term)->delete();
        return ['remove' => true, 'message' => 'Môn học '.$request->MaMon.' đã xóa thành công'];
    }
}
