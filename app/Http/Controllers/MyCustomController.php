<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\bangdiem;
use App\khoa;
use App\nganh;
use Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use App\course;

class MyCustomController extends Controller
{
    //
    public function getCourse(){
        return response()->json(course::get());
    }
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
            if(bangdiem::where('SinhViens_MaSV', 'like', '%'.$line['MaSV'].'%')->where('MaMH', $line['MaMon'])->count() ==1){
                return bangdiem::where('SinhViens_MaSV', $line['MaSV'])
                ->where('MaMH', $line['MaMon'])
                ->update(['Diem' => $line['Diem']]);
            }
            else{
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
            }

        });
        
        return redirect('/sinhvien/list')->with('success', 'Thêm dữ liệu thành công.');
    }
    function getAjaxBD($maSV){
        $monhoc = DB::table('bangdiems')->select('bangdiems.*')->where('SinhViens_MaSV', '=', $maSV)->get();
        return $monhoc;
    }

    public function danhSachBiHuyInfo(Request $request){
        $maSV = $request->maSV;
        //Lấy thông tin sinh viên
        $sv = DB::table('sinhviens')->where('MaSV', 'like', '%'.$maSV.'%');
        $ten = $sv->value('TenSV');
        $nganh = $sv->value('MaNganh');
        $khoa = $sv->value('MaKhoa');
        $lop = $sv->value('Lop');
        $khoas = $sv->value('Khoa');
        $dot = $sv->value('DotXets_MaDX');
        $LT =  DB::table('chuong_trinh_hocs')
                    ->where('Nganh', $nganh)
                    ->where('khoas', $khoas)
                    ->orderBy('Term', 'asc')
                    ->get();
        $cth = DB::table('bangdiems')
                    ->where('SinhViens_MaSV', 'like', '%'.$maSV.'%')
                    ->join('chuong_trinh_hocs', 'chuong_trinh_hocs.MaMon', '=', 'bangdiems.MaMH')
                    ->where('chuong_trinh_hocs.Nganh','like', $nganh)
                    ->where('chuong_trinh_hocs.khoas', '=', $khoas)
                    ->whereIn('Term', [0,1])
                    ->orderBy('Term', 'asc')
                    ->orderBy('MaMH', 'asc')
                    ->get();
        $bangdiem = DB::table('bangdiems')->where('SinhViens_MaSV', 'like', '%'.$maSV.'%')->orderBy('Diem', 'desc')->get();
        $cntc = DB::table('chuong_trinh_hocs')
                    ->where('Nganh', $nganh)
                    ->where('khoas', $khoas)->where('Term', 2)
                ->join('bangdiems', 'bangdiems.MaMH', '=', 'chuong_trinh_hocs.MaMon')
                ->where('SinhViens_MaSV', 'like', '%'.$maSV.'%')
                ->orderBy('Diem', 'desc')
                ->get();
        $DieuKien = DB::table('bang_dieu_kiens')->where('courseCode', '=', $khoas)->where('MaNganh', '=', $nganh);
        $diemRQ = $DieuKien->value('DiemTB');
        $tinchiTD = $DieuKien->value('TinTD');
        $tinchiTC = $DieuKien->value('TinTC');
        $monTT = DB::table('mon_thay_thes')
                ->join('chuong_trinh_hocs', 'chuong_trinh_hocs.MaMon', '=', 'mon_thay_thes.MaMH')
                ->where('Nganh', $nganh)
                ->join('bangdiems', 'bangdiems.MaMH', 'mon_thay_thes.MaMTT')
                ->where('SinhViens_MaSV', 'like', '%'.$maSV.'%')
                ->get();
        $tinchiNN = 4;
        $text = "";
        foreach ($monTT as $value) {
            $newt = $value->MaMTT;
            $newy = $value->MaMon;
            if($cth->where('MaMon', '=', $newy)->count() == 0 ){
                $textMH = DB::table('bangdiems')
                    ->join('mon_thay_thes', 'mon_thay_thes.MaMTT','=', 'bangdiems.MaMH')
                    ->where('SinhViens_MaSV','like', '%'.$maSV.'%')
                    ->where('bangdiems.MaMH', '=', $newt)
                    ->value('mon_thay_thes.MaMH');
                $pos = strstr($text, $textMH);
                if($pos === false){
                    $text = $text.' '.$textMH.' ';
                    $db = DB::table('bangdiems')
                    ->join('mon_thay_thes', 'mon_thay_thes.MaMTT','=', 'bangdiems.MaMH')
                    ->where('SinhViens_MaSV','like', '%'.$maSV.'%')
                    ->where('bangdiems.MaMH', '=', $newt)
                    ->get();
                    $cth = $cth->merge($db);
                }
                else{
                    continue;
                }
            }
        }
        $nn = DB::table('bangdiems')
            ->where('SinhViens_MaSV', $maSV)
            ->join('ngon_ngu2s', 'ngon_ngu2s.MaMon','=', 'bangdiems.MaMH')
            ->where('Loai', 'NN1')
            ->where('Diem', '>=', $diemRQ)
            ->select('MaMon', 'Diem', 'SoTC')
            ->orderBy('Diem', 'desc')
            ->get();
        $mm1 = NULL;
        $mm2 = NULL;
        $nnFlag = false;
        $xetduyet = $cth;
        foreach ($nn as $key) {
            $str1 = $key->MaMon;
            $str = substr($str1, 0, -1);
            $str2 = $str.'2';
            $count = DB::table('bangdiems')
                    ->where('SinhViens_MaSV', $maSV)
                    ->where('MaMH', $str2)
                    ->where('Diem', '>=', $diemRQ)
                    ->count();
            if($count != 0){
                $nnFlag = true;
                $mm1 = $str1;
                $mm2 = $str2;
                break;
            }
        }
        if($mm1 != NULL && $mm2 != NULL){
            $final1 = DB::table('bangdiems')
                ->where('SinhViens_MaSV','like', '%'.$maSV.'%')
                ->where('MaMH','=', $str1)
                ->get();   
            $final2 = DB::table('bangdiems')
                ->where('SinhViens_MaSV','like', '%'.$maSV.'%')
                ->Where('MaMH','=', $str2)
                ->get();
            $final = $final1->merge($final2);
            $xetduyet = $xetduyet->merge($final);
        }
        $flagT2 = False;
        $sumTC = 0;
        $temp = 0;
        $temptc = 0;
        $abc = $cntc;
        if($cntc->sum('SoTC') >= $tinchiTC)
            $flagT2 = True;
        foreach ($abc as $key) {
            if(isset($key->MaMH) && ($sumTC < $tinchiTC)){
                $temp = DB::table('chuong_trinh_hocs')
                    ->where('Nganh', $nganh)
                    ->where('khoas', $khoas)->where('Term', 2)
                    ->join('bangdiems', 'bangdiems.MaMH', '=', 'chuong_trinh_hocs.MaMon')
                    ->where('SinhViens_MaSV', 'like', '%'.$maSV.'%')
                    ->orderBy('Diem', 'desc')->where('MaMH',$key->MaMH)->get();
                $temptc = DB::table('chuong_trinh_hocs')
                    ->where('Nganh', $nganh)
                    ->where('khoas', $khoas)->where('Term', 2)
                    ->join('bangdiems', 'bangdiems.MaMH', '=', 'chuong_trinh_hocs.MaMon')
                    ->where('SinhViens_MaSV', 'like', '%'.$maSV.'%')
                    ->orderBy('Diem', 'desc')->where('MaMH',$key->MaMH)->value('SoTC');
                $xetduyet = $xetduyet->merge($temp);
                $sumTC = $sumTC + $temptc;
            }
            else
                break;
        }
        $arrMH = [];
        $arrT3 = [];
        $arrT2 = "";
        $i = 0;
        foreach ($xetduyet as $each) {
            if(isset($each->MaMTT)){
                $arrMH[$i] = $each->MaMTT;
                array_push($arrT3, $each->MaMH);
                if($each->Diem < $diemRQ)
                    $arrT2 .= $each->MaMTT." (".$each->TenMH." - ".$each->Diem."), </br>";
            }
            else{
                $arrMH[$i] = $each->MaMH;
                if($each->Diem < $diemRQ)
                    $arrT2 .= $each->MaMH." (".$each->TenMH." - ".$each->Diem."), </br>";
            }
            
            $i++;
        }
        $MHTerm3 = DB::table('bangdiems')
                ->where('SinhViens_MaSV','like', '%'.$maSV.'%')
                ->where('Diem', '>=', $diemRQ)
                ->whereNotIn('MaMH', $arrMH)
                ->orderBy('Diem', 'desc')
                ->get();
        foreach ($MHTerm3 as $key) {
            $key->Term = 3;
        }
        $xetduyet = $xetduyet->merge($MHTerm3);
        $TCTerm3 = $MHTerm3->where('Diem', '>=', $diemRQ)->sum('SoTC');
        $diemTB = round($xetduyet-> where('Diem', '>=', $diemRQ)->avg('Diem'),2);
        $tinchi = $xetduyet->where('Diem', '>=', $diemRQ)->sum('SoTC');
        $tinchiT0 = $LT->where('Term', 0)->sum('Tinchi');
        $tinchiT1 = $LT->where('Term', 1)->sum('Tinchi');
        $tinchiRQ = $tinchiT0 + $tinchiT1 + $tinchiNN + $tinchiTD + $tinchiTC;
        $NotLearn = DB::table('chuong_trinh_hocs')
                    ->where('Nganh', $nganh)
                    ->where('khoas', $khoas)
                    ->whereIn('Term', [0,1])
                    ->whereNotIn('MaMon', $arrMH)
                    ->whereNotIn('MaMon', $arrT3)
                    ->get();
        $arrT1 = "";
        
        foreach ($NotLearn as $key) {
            $arrT1 .= $key->MaMon." (".$key->TenMon."), </br>";
        }
        $tichiCL = 0;
        $DiemCL = 0;
        $TinTCCL = 0;
        $TinTDCL = 0;
        $NULL = "NULL";
        if($diemTB <= $diemRQ) $DiemCL="red";
        else $DiemCL="green";
        if($tinchi < $tinchiRQ) $tichiCL="red";
        else $tichiCL="blue";
        if($TCTerm3 < $tinchiTD) $TinTDCL="red";
        else $TinTDCL="blue";
        if(!($flagT2)) $TinTCCL="red";
        else $TinTCCL="blue";

        $output = '
        <div class="popup-list-main-1 col-sm-12">
            <div class="popup-list-main-1-1 col-sm-12 dfex">
                <div class="popup-list-main-1-1-1 col-sm-6 row dfex">
                    <p class="bold pr-5">TC tích lũy: </p><p class="'.$tichiCL.'">'.$tinchi.'/</p><p>'.$tinchiRQ.'</p>
                </div>
                <div class="popup-list-main-1-1-2 col-sm-6 row dfex">
                    <p class="bold pr-5">Điểm TB: </p><p class="'.$DiemCL.'">'.$diemTB.'</p>
                </div>
            </div>
            <div class="popup-list-main-1-1 col-sm-12 dfex">
                <div class="popup-list-main-1-1-1 col-sm-12 row dfex">
                    <p class="bold pr-5">Ngoại ngữ 2: </p><p>'.$mm1.', '.$mm2.'</p>
                </div>
            </div>
            <div class="popup-list-main-1-2 col-sm-12">
                <div class="popup-list-main-1-2-1">
                    <div class="popup-list-main-1-2-1-1 dblock col-sm-12 row">
                        <p class="bold pr-5">Chưa hoàn thành: </p><p>'.$arrT1.'</p>
                    </div>
                    <div class="popup-list-main-1-2-1-2 dblock col-sm-12 row">
                        <p class="bold pr-5">Không đủ điểm: </p><p>'.$arrT2.'</p>
                    </div>
                </div>
                <div class="popup-list-main-1-2-2 col-sm-12 row">
                    <div class="popup-list-main-1-2-2-1 dfex col-sm-6 row">
                        <p class="bold pr-5">Tự chọn CN: </p><p class="'.$TinTCCL.'">'.$sumTC.'/</p><p>'.$tinchiTC.'</p>
                    </div>
                    <div class="popup-list-main-1-2-2-1 dfex col-sm-6 row">
                        <p class="bold pr-5">Tín tự do: </p><p class="'.$TinTDCL.'">'.$TCTerm3.'/</p><p>'.$tinchiTD.'</p>
                    </div>
                </div>
            </div>
        </div>';

        echo ($output);
    }
}
