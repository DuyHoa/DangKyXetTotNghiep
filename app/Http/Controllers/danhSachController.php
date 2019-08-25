<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\danhSachdukien;
use App\danhSachChinhThuc;
use App\bangDieuKien;
use App\danhSachHuy;
use App\ngonNgu2;
use DB;
use Illuminate\Support\Facades\Validator;

class danhSachController extends Controller
{
    public function index(){
    	$list = DB::table('danh_sachdukiens')
    			->select('*')
    			->get();
    	return response()->json($list);
    }
    public function get(){
    	$dk = bangDieuKien::get();
    	return view('danhsach.dieukien')->with('dk', $dk);
    }
    public function danhSachChinhThuc(){
    	$listct = danhSachChinhThuc::get();
    	return view('danhsach.chinhthuc')->with('listct', $listct);
    }
    public function danhSachChinhThucWithMD($maD){
    	$listct = danhSachChinhThuc::where("MaDot", '=', $maD)->get();
    	return $listct;
    }
    public function danhSachBiHuy(){
    	/*$val = danhSachHuy::join('sinhviens', 'sinhviens.MaSV', '=', 'danh_sach_huys.MaSV')
    				
    				->get();

    	$nganh = DB::table('nganhs')->join('sinhviens', 'sinhviens.MaNganh','=','nganhs.MaNganh')
    	->join('danh_sach_huys', 'danh_sach_huys.MaSV', '=', 'sinhviens.MaSV')
    	->where("MaDot", '=', $maD)
    	->get();
    	return response()->json($nganh);*/
    	return view('danhsach.huy');
    }
    public function danhSachBiHuyWithMD($maD){
    	return DB::table('nganhs')->join('sinhviens', 'sinhviens.MaNganh','=','nganhs.MaNganh')
    	->join('danh_sach_huys', 'danh_sach_huys.MaSV', '=', 'sinhviens.MaSV')
    	->where("MaDot", '=', $maD)
    	->get();
    }
    public function danhSachWithMD(){
    	$list = DB::table('dotxets')
    			->select('*')
    			->get();
    	return view('danhsach.dukien')->with('list', $list);
    }
    public function danhSachWithMaDot($maD){
    	$listwithcode = DB::table('danh_sachdukiens')
    			->select('*')
    			->where('MaDot', '=', $maD)
    			->orWhere('MaSV', '=', $maD)
    			->get();
    	return response()->json($listwithcode);
    }

    public function createList(Request $request){
    	$MaSV = $request->MaSV;
    	if(danhSachdukien::count() == 0){
    		DB::table('danh_sachdukiens')->truncate();
    	}
    	if(danhSachdukien::where('MaSV', 'like', '%'.$MaSV.'%')->count() == 0){
	    	$TenSV = DB::table('sinhviens')->where('MaSV', 'like', '%'.$MaSV.'%')->value('TenSV');
	    	$Nganh = DB::table('sinhviens')->where('MaSV', 'like', '%'.$MaSV.'%')->value('MaNganh');
	    	$Lop = DB::table('sinhviens')->where('MaSV', 'like', '%'.$MaSV.'%')->value('Lop');
	    	$MaDot = DB::table('sinhviens')->where('MaSV', 'like', '%'.$MaSV.'%')->value('DotXets_MaDX');
	    	$TinhTrang = 0;
	    	$listStudent = new danhSachdukien;
	    	$listStudent->MaSV = $MaSV;
	    	$listStudent->TenSV = $TenSV;
	    	$listStudent->MaNganh = $Nganh;
	    	$listStudent->Lop = $Lop;
	    	$listStudent->MaDot = $MaDot;
	    	$listStudent->TinhTrang = $TinhTrang;
	    	$listStudent->save();
	    	//return response()->json($listStudent);
	    	return back()->with('success', 'Đã thêm sinh vien thành công');
	    }
	    else{
	    	return back()->with('error', 'Sinh viên đã tồn tại');
	    }
    	//
    }

    public function store(Request $request){
    	$MaNganh = $request->MaNganh;
    	$TongTC = $request->TongTC;
    	$DiemTB = $request->DiemTB;
    	$MaDot = $request->MaDot;
    	$rules = [
            'MaNganh' =>'required',
            'TongTC' => 'required|integer|',
            'DiemTB' => 'required|numeric|',
            'MaDot' => 'required',
        ];
        $messages = [
            'TongTC.required' => 'Tổng tín chỉ là trường bắt buộc',
            'DiemTB.required' => 'Điểm trung bình là trường bắt buộc',
            'MaDot.required' => 'Đợt xét là trường bắt buộc',
            'MaNganh.required' => 'Ngành là trường bắt buộc',
            'TongTC.integer' => 'Tổng tín chỉ phải là số nguyên',
            'DiemTB.numeric' => 'Điểm Trung bình phải là số',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
        	return back()->withErrors($validator)->withInput();
        }
        else{
        	if(bangDieuKien::count() == 0){
	    		DB::table('bang_dieu_kiens')->truncate();
	    	}
	    	if(bangDieuKien::where('MaNganh', '=', $MaNganh)->where('MaDot', '=', $MaDot)->count() != 0){
	    		bangDieuKien::where('MaNganh', '=', $MaNganh)
	    					->where('MaDot', '=', $MaDot)
	    					->update(['TongTC'=> $TongTC, 'DiemTB'=>$DiemTB]);
	    		return back()->with('info', 'Đã thêm điều kiện thành công');
	    	}
	    	else {
	    		$dk = new bangDieuKien;
	    		$dk->MaNganh = $MaNganh;
	    		$dk->TongTC = $TongTC;
	    		$dk->DiemTB = $DiemTB;
	    		$dk->MaDot = $MaDot;
	    		$dk->save();
	    		return  back()->with('success', 'Đã thêm điều kiện thành công');
	    	}

	    }
    }

    public function fetch($maN, $dot){
    	return bangDieuKien::where('MaNganh', '=', $maN)->where('MaDot', '=', $dot)->get();
    }
    public function xetduyetauto(Request $request){
		$maSV = $request->maSV;
    	$sv = DB::table('sinhviens')->where('MaSV', 'like', '%'.$maSV.'%');
    	//Lấy chương trình học
        
    	$ten = $sv->value('TenSV');
    	//Lấy mã ngành
    	$nganh = $sv->value('MaNganh');
    	//Lấy mã Khoa
    	$khoa = $sv->value('MaKhoa');
    	//Lấy mã lớp
    	$lop = $sv->value('Lop');
    	//Lấy đợt của sinh viên
    	$dot = $sv->value('DotXets_MaDX');

    	$cth = DB::table('bangdiems')
                    ->where('SinhViens_MaSV', 'like', '%'.$maSV.'%')
                    ->join('chuong_trinh_hocs', 'chuong_trinh_hocs.MaMon', '=', 'bangdiems.MaMH')
                    ->where('chuong_trinh_hocs.Nganh', $nganh)
                    ->get();
    	
    	
        //Lấy điểm TB cài đặt
        $diemRQ = DB::table('bang_dieu_kiens')->where('MaDot', '=', $dot)->where('MaNganh', '=', $nganh)->value('DiemTB');
        //Lấy tín chỉ cài đặt
        $tinchiRQ = DB::table('bang_dieu_kiens')->where('MaDot', '=', $dot)->where('MaNganh', '=', $nganh)->value('TongTC');


        //Lấy thông tin các môn có thể thay thế môn trong chương trình học và có điểm
        $monTT = DB::table('mon_thay_thes')
                ->join('chuong_trinh_hocs', 'chuong_trinh_hocs.MaMon', '=', 'mon_thay_thes.MaMH')
                ->where('Nganh', $nganh)
                ->join('bangdiems', 'bangdiems.MaMH', 'mon_thay_thes.MaMTT')
                ->where('SinhViens_MaSV', 'like', '%'.$maSV.'%')
                ->get();

        $text = "";
        //Thêm điểm thông tin các môn thay thế vào chương trình học
        foreach ($monTT as $value) {
            $newt = $value->MaMTT;
            $newy = $value->MaMon;
            //Loại bỏ các môn đã có trong chương trình học
            
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
                //echo $text;
            }
        }

        $nn = DB::table('bangdiems')
            ->where('SinhViens_MaSV', $maSV)
            ->join('ngon_ngu2s', 'ngon_ngu2s.MaMon','=', 'bangdiems.MaMH')
            ->where('Loai', 'NN1')
            ->where('Diem', '>=', 4.6)
            ->select('MaMon', 'Diem', 'SoTC')
            ->get();

        $nnFlag = false;
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
                $mm3 = $str1;
                $mm4 = $str2;
                break;
            }
        }
        $final1 = DB::table('bangdiems')
            ->where('SinhViens_MaSV','like', '%'.$maSV.'%')
            ->where('MaMH','=', $str1)
            ->get();   
        $final2 = DB::table('bangdiems')
            ->where('SinhViens_MaSV','like', '%'.$maSV.'%')
            ->Where('MaMH','=', $str2)
            ->get();

        $final = $final1->merge($final2);
        $xetduyet = $cth->merge($final);

        //Lấy điểm tb của chương trình học
        $diemTB = round($xetduyet->where('Diem', '>=', 4.6)->avg('Diem'),2);

        //Lấy tín chỉ tích lũy theo ngành
        $tinchi = $xetduyet->where('Diem', '>=', 4.6)->sum('Tinchi');

        function getRank($DTB){
        	if($DTB >= 8.5)
        		$rank = "Xuất sắc";
        	elseif($DTB < 8.5 && $DTB >= 8)
        		$rank = "Giỏi";
        	elseif($DTB < 8 && $DTB >= 7)
        		$rank = "Khá";
        	elseif($DTB < 7 && $DTB >= 6)
        		$rank = "Trung bình khá";
        	else
        		$rank = "Trung bình";
        	return $rank;
        }

        if($tinchi >= $tinchiRQ && $cth->where('Diem','<', $diemRQ)->count() == 0 && $nnFlag){
        	$status = 0;
        	if(danhSachChinhThuc::count() == 0){
        		danhSachChinhThuc::truncate();
        	}
        	if(danhSachChinhThuc::where('MaSV', 'like', '%'.$maSV.'%')->count() == 0){
	        	$list = new danhSachChinhThuc;
		        	$list->MaSV = $maSV;
		        	$list->TenSV = $ten;
		        	$list->MaNganh = $nganh;
		        	$list->Lop = $lop;
		        	$list->MaDot = $dot;
		        	$list->Rank = getrank($diemTB);
		        	$list->TrangThai = $status;
		        	$list->save();
		        	DB::table('danh_sachdukiens')->where('MaSV', 'like', '%'.$maSV.'%')->update(['TinhTrang' => 1, 'isDat' => 1]);
                    danhSachHuy::where('MaSV', 'like', '%'.$maSV.'%')->delete();
		        return ['success' => true, 'message' => 'Sinh viên '.$maSV.' đủ điều kiện, đã đưa vào danh sách chính thức'];
	        	//return response()->json($list);
	        }
	        else{
	        	return ['success' => true, 'message' => 'Sinh viên '.$maSV.' đã tồn tại trong danh sách chính thức'];
        	}
        }
        else{
        	if(danhSachHuy::count() == 0){
        		danhSachHuy::truncate();
        	}
        	if(danhSachHuy::where('MaSV', '=', $maSV)->count() == 0){
	        	$listCancel = new danhSachHuy;
	        	$listCancel->MaSV = $maSV;
	        	$listCancel->TenSV = $ten;
			    $listCancel->MaNganh = $nganh;
			    $listCancel->MaDot = $dot;
			    $listCancel->save();
			    $tempVal = DB::table('danh_sach_huys')->where('MaSV', '=', $maSV);
			    if($tinchi < $tinchiRQ)
			    	$tempVal->update(['Tinchi' => 0]);
			    else
			    	$tempVal->update(['Tinchi' => 1]);
			    if($cth->where('Diem','<', $diemRQ)->count() == 0)
			    	$tempVal->update(['Diem' => 1]);
			    else
			    	$tempVal->update(['Diem' => 0]);
                if($nnFlag)
                    $tempVal->update(['NN' => 1]);
                else
                    $tempVal->update(['NN' => 0]);

			    DB::table('danh_sachdukiens')->where('MaSV', 'like', '%'.$maSV.'%')->update(['TinhTrang' => 1, 'isDat' => 0]);
                danhSachChinhThuc::where('MaSV', 'like', '%'.$maSV.'%')->delete();
			    return ['success' => true, 'message' => 'Sinh viên '.$maSV.' không đủ điều kiện, đã đưa vào danh sách Chưa đủ điều kiện'];
			}
			else{
				return ['success' => true, 'message' => 'Sinh viên '.$maSV.' đã tồn tại trong danh sách Chưa đủ điều kiện'];
			}
        }
    	//return response()->json($diemRQ);
    }
}
