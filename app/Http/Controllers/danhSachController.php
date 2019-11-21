<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\danhSachdukien;
use App\danhSachChinhThuc;
use App\bangDieuKien;
use App\danhSachHuy;
use App\ngonNgu2;
use App\statistic;
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
    	$listct = DB::table('dotxets')
                ->select(DB::raw('DATE_FORMAT(NgayBatDau, "%Y") as formatted_NgayBatDau'))
                ->groupBy('formatted_NgayBatDau')
                ->get();
    	return view('danhsach.chinhthuc')->with('listct', $listct);
    }
    public function danhSachChinhThucWithMD($maD){
    	$listct = danhSachChinhThuc::where("MaDot", '=', $maD)->get();
    	return $listct;
    }
    public function danhSachBiHuy(){
    	$val = DB::table('dotxets')
                ->select(DB::raw('DATE_FORMAT(NgayBatDau, "%Y") as formatted_NgayBatDau'))
                ->groupBy('formatted_NgayBatDau')
                ->get();
    	return view('danhsach.huy')->with('val', $val);;
    }
    //danh sách hủy
    public function danhSachBiHuyWithMD($maD){
    	return DB::table('nganhs')->join('sinhviens', 'sinhviens.MaNganh','=','nganhs.MaNganh')
    	->join('danh_sach_huys', 'danh_sach_huys.MaSV', '=', 'sinhviens.MaSV')
    	->where("MaDot", '=', $maD)
    	->get();
    }
    public function danhSachWithMD(){
    	$list = DB::table('dotxets')
    			->select(DB::raw('DATE_FORMAT(NgayBatDau, "%Y") as formatted_NgayBatDau'))
                ->groupBy('formatted_NgayBatDau')
    			->get();
    	return view('danhsach.dukien')->with('list', $list);
    }
    public function fillName(Request $request){
        $data = DB::table('dotxets')->whereYear('NgayBatDau', $request->NgayBatDau)->get();
        $output = '<option value="">Chọn đợt</option>';
        if($data->count() != 0){
            foreach ($data as $key) {
                $output .= '<option value="'.$key->MaDX.'">'.$key->TenDX.'</option>';
            }
        }
        echo $output;
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
    	$TinTD = $request->TinTD;
        $TinTC = $request->TinTC;
    	$DiemTB = $request->DiemTB;
    	$courseCode = $request->courseCode;
    	$rules = [
            'MaNganh' =>'required',
            'TinTD' => 'required|integer|',
            'TinTC' => 'required|integer|',
            'DiemTB' => 'required|numeric|',
            'courseCode' => 'required',
        ];
        $messages = [
            'TinTD.required' => 'Tín tự do là trường bắt buộc',
            'TinTC.required' => 'Tín tự chọn là trường bắt buộc',
            'DiemTB.required' => 'Điểm trung bình là trường bắt buộc',
            'courseCode.required' => 'Khóa là trường bắt buộc',
            'MaNganh.required' => 'Ngành là trường bắt buộc',
            'TinTD.integer' => 'Tín tự do phải là số nguyên',
            'TinTC.integer' => 'Tín tự chọn phải là số nguyên',
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
	    	if(bangDieuKien::where('MaNganh', '=', $MaNganh)->where('courseCode', '=', $courseCode)->count() != 0){
	    		bangDieuKien::where('MaNganh', '=', $MaNganh)
	    					->where('courseCode', '=', $courseCode)
	    					->update(['TinTC'=> $TinTC, 'DiemTB'=>$DiemTB, 'TinTD'=> $TinTD]);
	    		return back()->with('info', 'Đã thêm điều kiện thành công');
	    	}
	    	else {
	    		$dk = new bangDieuKien;
	    		$dk->MaNganh = $MaNganh;
	    		$dk->TinTD = $TinTD;
                $dk->TinTC = $TinTC;
	    		$dk->DiemTB = $DiemTB;
	    		$dk->courseCode = $courseCode;
	    		$dk->save();
	    		return  back()->with('success', 'Đã thêm điều kiện thành công');
	    	}

	    }
    }

    public function fetch($maN, $courseCode){
    	return bangDieuKien::where('MaNganh', '=', $maN)->where('courseCode', '=', $courseCode)->get();
    }
    public function xetduyetauto(Request $request){
		$maSV = $request->maSV;
        $khoas = $request->khoas;
    	//Lấy thông tin sinh viên
        $sv = DB::table('sinhviens')->where('MaSV', 'like', '%'.$maSV.'%');
        $ten = $sv->value('TenSV');
        $nganh = $sv->value('MaNganh');
        $khoa = $sv->value('MaKhoa');
        $lop = $sv->value('Lop');
        $dot = $sv->value('DotXets_MaDX');
        if(DB::table('chuong_trinh_hocs')->where('Nganh', $nganh)->where('khoas', $khoas)->count() == 0){
            return ['success' => true, 'message' => 'Chương trình học cho niên khóa '.$khoas.' chưa được khởi tạo'];
        }else{
            if(DB::table('chuong_trinh_hocs')->where('Nganh', $nganh)->where('khoas', $khoas)->count() == 0){
                return ['success' => true, 'message' => 'Điều kiện cho niên khóa '.$khoas.' của ngành '.$nganh.' chưa được khởi tạo'];
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
                /*$tinchiCN = DB::table('chuong_trinh_hocs')->where('Nganh', $nganh)->where('khoas','=', $khoas)->sum('Tinchi');
                $tinchiRQ = $tinchiCN;*/
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
                    ->where('Diem', '>=', $diemRQ)
                    ->select('MaMon', 'Diem', 'SoTC')
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

                $arrMH = [];
                $i = 0;
                foreach ($xetduyet as $each) {
                    if(isset($each->MaMTT))
                        $arrMH[$i] = $each->MaMTT;
                    else
                        $arrMH[$i] = $each->MaMH;
                    $i++;
                }
                //Lấy môn tự do
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
                //Lấy điểm tb của chương trình học
                $diemTB = round($xetduyet->where('Diem', '>=', $diemRQ)->avg('Diem'),2);

                //Lấy tín chỉ tích lũy theo ngành
                $tinchi = $xetduyet->where('Diem', '>=', $diemRQ)->sum('SoTC');

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

                
                
                $TCTerm3 = $MHTerm3->where('Diem', '>=', $diemRQ)->sum('SoTC');
                $tinchiNN = 4;
                $tinchiT0 = $LT->where('Term', 0)->sum('Tinchi');
                $tinchiT1 = $LT->where('Term', 1)->sum('Tinchi');
                $tinchiRQ = $tinchiT0 + $tinchiT1 + $tinchiTD + $tinchiTC;

                if($tinchi >= $tinchiRQ && $cth->where('Diem','<', $diemRQ)->count() == 0 && $nnFlag && $TCTerm3 >= $diemRQ && $flagT2){
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
                            if(statistic::where('year' , date('Y'))->where('MaKhoa', $khoa)->where('MaNganh', $nganh)->count() == 0){
                                $statistic = new statistic;
                                $statistic->year = date('Y');
                                $statistic->MaKhoa = $khoa;
                                $statistic->MaNganh = $nganh;
                                $statistic->count = 1;
                                $statistic->save();
                            }
                            else{
                                $now_c = statistic::where('year' , date('Y'))->where('MaKhoa', $khoa)->where('MaNganh', $nganh)->value('count');
                                statistic::where('year' , date('Y'))->where('MaKhoa', $khoa)->where('MaNganh', $nganh)->update(['count' => $now_c+1]);
                            }
        		        return ['success' => true, 'message' => 'Sinh viên '.$maSV.' đủ điều kiện, đã đưa vào danh sách chính thức'];
        	        	//return response()->json($list);
        	        }
        	        else{
        	        	return ['success' => true, 'message' => 'Xét duyệt lại sinh viên '.$maSV.', vẫn đủ điều kiện xét tốt nghiệp'];
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
                        if($TCTerm3 >= $diemRQ)
                            $tempVal->update(['Tudo' => 1]);
                        else
                            $tempVal->update(['Tudo' => 0]);
        			    DB::table('danh_sachdukiens')->where('MaSV', 'like', '%'.$maSV.'%')->update(['TinhTrang' => 1, 'isDat' => 0]);
                        danhSachChinhThuc::where('MaSV', 'like', '%'.$maSV.'%')->delete();
        			    return ['success' => true, 'message' => 'Sinh viên '.$maSV.' không đủ điều kiện, đã đưa vào danh sách Chưa đủ điều kiện'];
        			}
        			else{
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
                        if($TCTerm3 >= $diemRQ)
                            $tempVal->update(['Tudo' => 1]);
                        else
                            $tempVal->update(['Tudo' => 0]);
                        DB::table('danh_sachdukiens')->where('MaSV', 'like', '%'.$maSV.'%')->update(['TinhTrang' => 1, 'isDat' => 0]);
                        danhSachChinhThuc::where('MaSV', 'like', '%'.$maSV.'%')->delete();
        				return ['success' => true, 'message' => 'Xét duyệt lại sinh viên '.$maSV.', vẫn KHÔNG đủ điều kiện xét tốt nghiệp'];
        			}
                }
            	/*return response()->json($tinchiRQ);*/
            }
        }
    }
}
