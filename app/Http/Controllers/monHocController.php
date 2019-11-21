<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\monhoc;
use App\ngonNgu2;
use App\monThayThe;
use Illuminate\Support\Facades\Validator;

class monHocController extends Controller
{
    public function getDataMonhoc()
    {
    	$gmonhoc = DB::table('monhocs')->select('monhocs.*')->get();
        return view('monhoc.get-subject', ['gmonhoc' => $gmonhoc]);
    }

    function getMonHoc($maMH){
        $monhoc = DB::table('monhocs')->select('monhocs.*')->where('MaMon', '=', $maMH)->get();
        return $monhoc;
    }
    public function insertmonhoc(Request $request)
    {
        $rules = [
            'MaMon' =>'required|min:2|string|',
            'TenMon' => 'required|string|',
            'TinChi'  => 'required|numeric|min:1|',
        ];
        $messages = [
            'MaMon.required' => 'Mã môn là trường bắt buộc',
            'TenMon.required' => 'Tên môn là trường bắt buộc',
            'TinChi.required' => 'Tín chỉ là trường bắt buộc',
            'MaMon.min' => 'Mã môn phải 2 kí tự trở lên',
            'TenMon.string' => 'Tên môn phải là kí tự',
            'MaMon.string' => 'Mã môn phải là kí tự',
            'TinChi.numeric' => 'Tín chỉ phải là số',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else{
            if(monhoc::where('MaMon', $request->MaMon)->count() == 0){
                $monhoc = monhoc::create($request->all());
                return redirect('/monhoc/list')->with('success', 'Thêm dữ liệu thành công.');   
            }
            else
                return back()->withErrors('Môn học: '.$request->MaMon.' đã tồn tại');
        }
        
        
    }

    public function edit($MaMon)
    {
        $monhoc = DB::table('monhocs')->where('MaMon', $MaMon)->first();
        return view('monhoc.edit-subject', compact('monhoc'))->with('MaMon', $MaMon);
    }
    public function update(Request $request){
        $rules = [
            'MaMon' =>'required|min:8|string|',
            'TenMon' => 'required|string|',
            'TinChi'  => 'required|numeric|min:1|',
        ];
        $messages = [
            'MaMon.required' => 'Mã môn là trường bắt buộc',
            'TenMon.required' => 'Tên môn là trường bắt buộc',
            'TinChi.required' => 'Tín chỉ là trường bắt buộc',
            'MaMon.min' => 'Mã khoa phải 5 kí tự trở lên',
            'TenMon.string' => 'Tên môn phải là kí tự',
            'MaMon.string' => 'Mã môn phải là kí tự',
            'TinChi.numeric' => 'Tín chỉ phải là số',
        ];
        /*$validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else{*/
            if(monhoc::where('MaMon', $request->MaMon)->count() == 0){
                return back()->withErrors('Mã môn học không hợp lệ, Cập nhật thất bại.');
            }
            else{
                DB::table('monhocs')->where('MaMon', $request->MaMon)->update(['TenMon' => $request->TenMon, 'TinChi' => $request->TinChi]);
                return redirect('monhoc/list')->with('success', 'Cập nhật dữ liệu thành công.');
            }
        /*}*/
        

    }
    public function delete(Request $request)
    {
        DB::table('monhocs')->where('MaMon', $request->MaMon)->delete();
        return back()->with('remove', 'Xóa dữ liệu thành công.');
    }

    public function search($content)
    {
        return DB::table('monhocs')
                ->select('*')
                ->where('MaMon', 'LIKE', '%'.$content.'%')
                ->orwhere('TenMon', 'LIKE', '%'.$content.'%')
                ->get();
    }

    public function getMonHocNN(){
        $nn = ngonNgu2::get();
        return view('monhoc.ngonngu')->with('nn',$nn);
    }
    public function postMonHocNN(Request $request){
        $rules = [
            'MaMon' =>'required|min:5|string|',
            'TenMon' => 'required|string|',
            'Loai'  => 'required|',
        ];
        $messages = [
            'MaMon.required' => 'Mã môn là trường bắt buộc',
            'TenMon.required' => 'Tên môn là trường bắt buộc',
            'Loai.required' => 'Thuộc nhóm là trường bắt buộc',
            'MaMon.min' => 'Mã môn phải 5 kí tự trở lên',
            'TenMon.string' => 'Tên môn phải là kí tự',
            'MaMon.string' => 'Mã môn phải là kí tự',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else{
            $TenMon = $request->TenMon;
            $MaMon = $request->MaMon;
            $Loai = $request->Loai;
            if(ngonNgu2::count() == 0)
                ngonNgu2::truncate();
            if(ngonNgu2::where('MaMon', $MaMon)->count() != 0)
                return redirect('/mh/nn2')->withErrors('Môn học đã tồn tại');
            else{
                $nn = new ngonNgu2;
                $nn->MaMon = $MaMon;
                $nn->TenMon = $TenMon;
                $nn->Loai = $Loai;
                $nn->save();
                return redirect('/mh/nn2')->withSuccess('Môn học đã được thêm thành công');
            }
        }
    }
    public function findNN($maMH){
        $fnn = DB::table('ngon_ngu2s')->where('MaMon', $maMH)->first();
        return view('monhoc.edit-ngonngu')->with('fnn', $fnn);
    }
    public function updateNN(Request $request){
        $rules = [
            'MaMon' =>'required|min:5|string|',
            'TenMon' => 'required|string|',
            'Loai'  => 'required|',
        ];
        $messages = [
            'MaMon.required' => 'Mã môn là trường bắt buộc',
            'TenMon.required' => 'Tên môn là trường bắt buộc',
            'Loai.required' => 'Thuộc nhóm là trường bắt buộc',
            'MaMon.min' => 'Mã khoa phải 5 kí tự trở lên',
            'TenMon.string' => 'Tên môn phải là kí tự',
            'MaMon.string' => 'Mã môn phải là kí tự',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else{
            if(DB::table('ngon_ngu2s')->where('MaMon','=', $request->MaMon)->count() == 0){
                return back()->withErrors('Mã môn học không hợp lệ, Cập nhật thất bại.');
            }
            else{
                DB::table('ngon_ngu2s')->where('MaMon','=', $request->MaMon)->update(['TenMon' => $request->TenMon, 'Loai' => $request->Loai]);
                return redirect('mh/nn2')->with('success', 'Cập nhật dữ liệu thành công.');
            }
        }
    }
    public function deleteNN(Request $request){
        DB::table('ngon_ngu2s')->where('MaMon', $request->MaMon)->delete();
        return back()->with('remove', 'Xóa dữ liệu thành công.');
    }
    public function getMonHocNNJS(){
        return response()->json(ngonNgu2::get());
    }
    public function danhSachMTT(){
        $tt = DB::table('mon_thay_thes')->join('monhocs', 'monhocs.MaMon', '=', 'mon_thay_thes.MaMH')->orderBy('MaMon', 'asc')->get();
        $MaTT = [];
        for($i = 0; $i < count($tt); $i++){
            array_push($MaTT, $tt[$i]->MaMTT);
            $MaTemp = $tt[$i]->MaMTT;
            $TenTT = DB::table('monhocs')->Where('MaMon','like', $MaTemp)->value('TenMon');
            $tt[$i]->TenMTT = $TenTT;
        }
        return view('monhoc.thaythe-subject')->with('tt', $tt);
    }

    public function testDSMTT(){
        $tt = DB::table('mon_thay_thes')->join('monhocs', 'monhocs.MaMon', '=', 'mon_thay_thes.MaMH')->orderBy('MaMon', 'asc')->get();
        $MaTT = [];
        for($i = 0; $i < count($tt); $i++){
            array_push($MaTT, $tt[$i]->MaMTT);
            $MaTemp = $tt[$i]->MaMTT;
            $TenTT = DB::table('monhocs')->Where('MaMon','like', $MaTemp)->value('TenMon');
            $tt[$i]->TenMTT = $TenTT;
        }

        return response()->json($tt);
    }

    public function postDanhSachMTT(Request $request){
        $rules = [
            'MaMH' =>'required|min:5|string',
            'MaMTT' => 'required|min:5|string',
        ];
        $messages = [
            'MaMH.required' => 'Mã môn là trường bắt buộc',
            'MaMTT.required' => 'Mã môn thay thế là trường bắt buộc',
            'MaMTT.min' => 'Mã môn thay thế phải 5 kí tự trở lên',
            'MaMH.min' => 'Mã môn phải 5 kí tự trở lên',
            'MaMTT.string' => 'Mã môn thay thế phải là kí tự',
            'MaMH.string' => 'Mã môn phải là kí tự',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else{
            $MaMH = $request->MaMH;
            $MaMTT = $request->MaMTT;
            if(monThayThe::count() == 0)
                monThayThe::truncate();
            if(monhoc::where('MaMon', $MaMH)->count() == 0){
                return redirect('/mh/thaythe')->withErrors('Môn chưa có trong chương trình học!.');
            }
            else if (monhoc::where('MaMon', $MaMTT)->count() == 0){
                return redirect('/mh/thaythe')->withErrors('Môn thay thế chưa có trong chương trình học!.');
            }
            else{
                $mtt = new monThayThe;
                $mtt->MaMH = $MaMH;
                $mtt->MaMTT = $MaMTT;
                $mtt->save();
                return redirect('/mh/thaythe')->withSuccess('Đã thêm thành công!.');
            }
        }
    }
    public function ajaxDanhSachMTT(){
        return monThayThe::join('monhocs', 'monhocs.MaMon', '=', 'mon_thay_thes.MaMH')->orderBy('id','asc')->get();
    }
    public function editDanhSachMTT($id){
        $ob = monThayThe::where('id', $id)->select('id','MaMH','MaMTT')->get();
        return view('monhoc.editTTsubject')->with('ob', $ob);
    }
    public function updateDanhSachMTT(Request $request){
        $rules = [
            'MaMH' =>'required|min:5|string',
            'MaMTT' => 'required|min:5|string',
        ];
        $messages = [
            'MaMH.required' => 'Mã môn là trường bắt buộc',
            'MaMTT.required' => 'Mã môn thay thế là trường bắt buộc',
            'MaMTT.min' => 'Mã môn thay thế phải 5 kí tự trở lên',
            'MaMH.min' => 'Mã môn phải 5 kí tự trở lên',
            'MaMTT.string' => 'Mã môn thay thế phải là kí tự',
            'MaMH.string' => 'Mã môn phải là kí tự',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else{
            if(monhoc::where('MaMon', $request->MaMH)->count() == 0)
                return back()->withErrors('Mã môn học ko hợp lệ');
            else if(monhoc::where('MaMon', $request->MaMTT)->count() == 0)
                return back()->withErrors('Mã môn học thay thế ko hợp lệ');
            else{
                monThayThe::where('id', $request->id)->update(['MaMH'=> $request->MaMH, 'MaMTT' => $request->MaMTT,]);
                return redirect('/mh/thaythe')->withSuccess('Cập nhật thành công!.');
            }
        }
    }
    public function deleteDanhSachMTT(Request $request){
        monThayThe::where('id', $request->id)->delete();
        return back()->withErrors('Xóa thành công thành công!.');
    }
    public function test($maSV, $maK){
        //Lấy thông tin sinh viên
        $sv = DB::table('sinhviens')->where('MaSV', 'like', '%'.$maSV.'%');
        $ten = $sv->value('TenSV');
        $nganh = $sv->value('MaNganh');
        $khoa = $sv->value('MaKhoa');
        $lop = $sv->value('Lop');
        $khoas = $maK;
        $dot = $sv->value('DotXets_MaDX');
        
        //Lấy chương trình học
        if(DB::table('chuong_trinh_hocs')->where('Nganh', $nganh)->where('khoas', $khoas)->count() == 0){
            return ['success' => true, 'message' => 'Chương trình học cho niên khóa '.$khoas.' chưa được khởi tạo'];
        }else{
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
            //Lấy điểm TB cài đặt
            $diemRQ = $DieuKien->value('DiemTB');
            //Tin chỉ tự do
            $tinchiTD = $DieuKien->value('TinTD');
            //Tin chỉ chuyên ngành
            $tinchiTC = $DieuKien->value('TinTC');
            //Lấy tín chỉ cài đặt
            //$tinchiCN = DB::table('chuong_trinh_hocs')->where('Nganh', $nganh)->where('khoas','=', $khoas)->sum('Tinchi');
            //$tinchiRQ = $tinchiCN;
            //Lấy thông tin các môn có thể thay thế môn trong chương trình học và có điểm
            $monTT = DB::table('mon_thay_thes')
                    ->join('chuong_trinh_hocs', 'chuong_trinh_hocs.MaMon', '=', 'mon_thay_thes.MaMH')
                    ->where('Nganh', $nganh)
                    ->join('bangdiems', 'bangdiems.MaMH', 'mon_thay_thes.MaMTT')
                    ->where('SinhViens_MaSV', 'like', '%'.$maSV.'%')
                    ->get();
            $tinchiNN = 4;
            $text = "";
            $arrMTT = [];

            //Thêm điểm thông tin các môn thay thế vào chương trình học
            foreach ($monTT as $value) {
                $newt = $value->MaMTT;
                $newy = $value->MaMon;
                //Loại bỏ các môn đã có trong chương trình học
                
                if($cth->where('MaMon', '=', $newy)->count() == 0 ){
                    //Lấy mã môn học của môn thay thế có trong bảng điểm
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
                        array_push($arrMTT,$textMH);
                        $cth = $cth->merge($db);
                    }
                    else{
                        continue;
                    }
                    //echo $text;
                }
            }

            //Lấy các môn ngoại ngữ trong bảng điếm
            $nn = DB::table('bangdiems')
                ->where('SinhViens_MaSV', $maSV)
                ->join('ngon_ngu2s', 'ngon_ngu2s.MaMon','=', 'bangdiems.MaMH')
                ->where('Loai', 'NN1')
                ->where('Diem', '>=', $diemRQ)
                ->select('MaMon', 'Diem', 'SoTC')
                ->orderBy('Diem', 'desc')
                ->get();
            
            $mm1 = 0;
            $mm2 = 0;
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
            //Lấy điểm tb của chương trình học
            $diemTB = round($xetduyet-> where('Diem', '>=', $diemRQ)->avg('Diem'),2);

            //Lấy tín chỉ tích lũy theo ngành
            $tinchi = $xetduyet->where('Diem', '>=', $diemRQ)->sum('SoTC');
            $arrMH = [];
            $arrT3 = [];
            $i = 0;
            foreach ($xetduyet as $each) {
                if(isset($each->MaMTT)){
                    $arrMH[$i] = $each->MaMTT;
                    array_push($arrT3, $each->MaMH);
                }
                else
                    $arrMH[$i] = $each->MaMH;
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
            $arrT2 = "";

            foreach ($NotLearn as $key) {
                $arrT1 .= $key->MaMon.", ";
            }            
            return response()->json($arrT1);
        }
    }
}
