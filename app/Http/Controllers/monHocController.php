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
            'MaMon' =>'required|min:5|string|',
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
            'MaMon' =>'required|min:5|string|',
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
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        else{
            if(monhoc::where('MaMon', $request->MaMon)->count() == 0){
                return back()->withErrors('Mã môn học không hợp lệ, Cập nhật thất bại.');
            }
            else{
                DB::table('monhocs')->where('MaMon', $request->MaMon)->update(['TenMon' => $request->TenMon, 'TinChi' => $request->TinChi]);
                return redirect('monhoc/list')->with('success', 'Sửa dữ liệu thành công.');
            }
        }
        

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
        $tt = monThayThe::join('monhocs', 'monhocs.MaMon', '=', 'mon_thay_thes.MaMH')->orderBy('id', 'asc')->get();
        return view('monhoc.thaythe-subject')->with('tt', $tt);
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
    public function test($maSV){
        /*$nn = DB::table('bangdiems')
            ->where('SinhViens_MaSV', $maSV)
            ->join('ngon_ngu2s', 'ngon_ngu2s.MaMon','=', 'bangdiems.MaMH')
            ->where('Loai', 'NN1')
            ->where('Diem','>', $diemRQ)
            ->select('ngon_ngu2s.MaMon')
            ->get();
        $result = $nn;
        foreach ($nn as $key) {
            $str = $key->MaMon;
        }*/
        //$nn2 = DB::table('bangdiems')->where('SinhViens_MaSV', $maSV)->where('MaMH', $nn)->get();
        //$str = substr($nn, 0, -1);
        //$str = $str.'2';

        //$diem = DB::table('bangdiems')->where('SinhViens_MaSV', $maSV)->where('MaMH', $str)->get();
        //$result = $nn2->merge($diem);

        /*$tt = monThayThe::get();
        $c = DB::table('chuong_trinh_hocs')->where('Nganh', 'TE')->get();
        $cth = DB::table('bangdiems')
            ->where('SinhViens_MaSV', $maSV)
            ->join('chuong_trinh_hocs', 'chuong_trinh_hocs.MaMon', '=', 'bangdiems.MaMH')
            ->where('Nganh', 'TE')
            ->get();

        //Lấy các môn có thể thay thế môn trong chương trình học
        $monTT = DB::table('mon_thay_thes')
                ->join('chuong_trinh_hocs', 'chuong_trinh_hocs.MaMon', '=', 'mon_thay_thes.MaMH')
                ->where('Nganh', 'TE')
                ->join('bangdiems', 'bangdiems.MaMH', 'mon_thay_thes.MaMTT')
                ->where('SinhViens_MaSV', $maSV)
                ->get();*/
        //$a = $cth->merge($result);
        /*foreach ($monTT as $value) {
            $newt = $value->MaMTT;
            $newy = $value->MaMon;
            if($cth->where('MaMon', '=', $value->MaMon)->count() == 0){
                $db = DB::table('bangdiems')
                    ->join('mon_thay_thes', 'mon_thay_thes.MaMTT','=', 'bangdiems.MaMH')
                    ->where('SinhViens_MaSV','like', '%'.$maSV.'%')
                    ->where('bangdiems.MaMH', '=', $newt)
                    ->where('bangdiems.MaMH', '!=', $newy)
                    ->get();
                $cth = $cth->merge($db);
            }
        }
        return response()->json($cth);
*/
    }
}
