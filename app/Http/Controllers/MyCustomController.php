<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\bangdiem;
use App\khoa;
use App\nganh;
use Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class MyCustomController extends Controller
{
    //
    public function test(){
    	$test = DB::table('khoa')->select('khoa.*')->get();
    	return $test;
    }

     public function importBangDiemUI()
    {
        return view('bangdiem.importbangdiem');
    }
 
   
    public function importBangDiemFuct(Request $request)
    {
        $request->validate([
            'import_file' => 'required'
        ]);
 
        $path = $request->file('import_file')->getRealPath();
        $users = (new FastExcel)->import($path, function ($line) {
            DB::table('sinhviens')
                ->where('MaSV', 'like', '%'.$line['MaSV'].'%')
                ->update(['isBD' => 1]);
            return bangdiem::create([
                'SinhViens_MaSV' => $line['MaSV'],
                'MaMH' => $line['MaMon'],
                'TenMH' => $line['TenMon'],
                'SoTC' => $line['TC'],
                'Diem' => $line['Diem'],
            ]);

        });

        return redirect('/sinhvien/list')->with('success', 'Thêm dữ liệu thành công.');
    }
    /*public function getbandiem(){
    	$petani = DB::table('bangdiems')->avg('Diem')->get();

    return view('bangdiem.getbangdiem', ['petani' => $petani]);
    }



    function getBD()
    {
     $petani = DB::table('bangdiems')->select('bangdiems.SinhViens_MaSV')
         ->groupBy('SinhViens_MaSV')
         ->get();
     return view('bangdiem.getbangdiem')->with('petani', $petani);
    }*/


    function getAjaxBD($maSV){
        $monhoc = DB::table('bangdiems')->select('bangdiems.*')->where('SinhViens_MaSV', '=', $maSV)->get();
        return $monhoc;
    }
}
