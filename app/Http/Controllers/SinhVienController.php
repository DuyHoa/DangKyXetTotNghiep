<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sinhvien;
use App\dotxet;
use App\nganh;
use App\khoa;
use App\bangdiem;
use DB;

class SinhVienController extends Controller
{
    public function __construct() {
		$this->middleware('auth');
	}
    //Lấy dữ liệu các đợt xét
    public function getDataDotXet()
    {
        $DotXet = DB::table('dotxets')->select('*')->get();
        return view('Student.dkxtn', ['DotXet' => $DotXet]);
    }

    //Xét duyệt thủ công sinh viên
    public function bangXetDuyet($maN, $maSV){
        $khoas = DB::table('sinhviens')->where('maSV', $maSV)->value('Khoa');
        $result = DB::table('bangdiems')
                    ->where('SinhViens_MaSV', 'like', '%'.$maSV.'%')
                    ->join('chuong_trinh_hocs', 'chuong_trinh_hocs.MaMon', '=', 'bangdiems.MaMH')
                    ->where('chuong_trinh_hocs.Nganh', $maN)
                    ->where('chuong_trinh_hocs.khoas', $khoas)
                    ->orderBy('Term', 'asc')
                    ->orderBy('MaMH', 'asc')
                    ->get();

        //Lấy thông tin các môn có thể thay thế môn trong chương trình học và có điểm           
        $monTT = DB::table('mon_thay_thes')
                ->join('chuong_trinh_hocs', 'chuong_trinh_hocs.MaMon', '=', 'mon_thay_thes.MaMH')
                ->where('Nganh', $maN)
                ->where('chuong_trinh_hocs.khoas', $khoas)
                ->join('bangdiems', 'bangdiems.MaMH', '=', 'mon_thay_thes.MaMTT')
                ->where('SinhViens_MaSV', 'like', '%'.$maSV.'%')
                ->get();
        $i = 0;
        $text = "";
        //Thêm điểm thông tin các môn thay thế vào chương trình học
        foreach ($monTT as $value) {
            $newt = $value->MaMTT;
            $newy = $value->MaMon;
            //Loại bỏ các môn đã có trong chương trình học
            if($result->where('MaMon', '=', $newy)->count() == 0 ){
                
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
                    $result = $result->merge($db);
                    
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
            ->orderby('Diem', 'desc')
            ->get();


        $Ma_NN_1 = 0;
        $Ma_NN_2 = 0;
        $nnFlag = false;
        $xetduyet = $result;
        foreach ($nn as $key) {
            $str1 = $key->MaMon;
            $str = substr($str1, 0, -1);
            $str2 = $str.'2';
            $count = DB::table('bangdiems')
                    ->where('SinhViens_MaSV', $maSV)
                    ->where('MaMH', $str2)
                    ->where('Diem', '>=', 4.6)
                    ->count();
            if($count != 0){
                $Ma_NN_1 = $str1;
                $Ma_NN_2 = $str2;
                $nnFlag = true;
                break;
            }
        }
        if($Ma_NN_1 != NULL && $Ma_NN_2 != NULL){
            $final1 = DB::table('bangdiems')
                ->where('SinhViens_MaSV','like', '%'.$maSV.'%')
                ->where('MaMH', $Ma_NN_1)
                ->get();   
            $final2 = DB::table('bangdiems')
                ->where('SinhViens_MaSV','like', '%'.$maSV.'%')
                ->Where('MaMH', $Ma_NN_2)
                ->get();
            $final = $final1->merge($final2);
            $xetduyet = $result->merge($final);
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
        $MHTerm3 = DB::table('bangdiems')
                ->where('SinhViens_MaSV','like', '%'.$maSV.'%')
                ->where('Diem', '>=', 4.6)
                ->whereNotIn('MaMH', $arrMH)
                ->orderBy('Diem', 'desc')
                ->get();
        foreach ($MHTerm3 as $key) {
            $key->Term = 3;
        }
        $xetduyet = $xetduyet->merge($MHTerm3);
        return view('Student.xetduyet', ['xetduyet' => $xetduyet]);
    }

    //Lấy object theo mã đợt xét
    public function getDX($madot){
        $dx = DB::table('dotxets')->select('*')->where('MaDX', '=', $madot)->get();
        return $dx;
    }

    //trả về view getStudent
    public function getAllInforSV(){
        return view('bangdiem.getStudent');
    }

    //Lấy bảng điểm theo từng sinh viên
    public function bangdiemSV($MaSV){
        $petani = DB::table('bangdiems')
                ->where('SinhViens_MaSV', 'like', '%'.$MaSV.'%')
                ->join('sinhviens','sinhviens.MaSV', '=', 'bangdiems.SinhViens_MaSV' )
                ->get();
        //return response()->json($petani);
        return view('bangdiem.getbangdiem')->with('petani', $petani);
    }
	public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    // Đăng ký đợt xét cho mỗi sinh viên
    public function store(Request $request)
    {
        $temp1 = $request->MaSV;
        $temp2 = $request->DotXets_MaDX;
        $temp3 = DB::table('dotxets')
                ->where('MaDX', $temp2)
                ->value('Status');
        if($temp3 != 0){
            DB::table('sinhviens')->where('MaSV','like','%'.$temp1.'%')->update(['DotXets_MaDX' => $temp2]);
            /*return redirect('/dangky')->with('success', 'Đăng ký thành công');*/
            echo ($temp1.' '.$temp2.' '.$temp3);
        }
        else if($temp3 == 0)
            /*return redirect('/dangky')->with('danger', 'Hạn đăng ký đã kết thúc');*/
            /*echo ($temp1.' '.$temp2.' '.$temp3);*/
            return $temp3;
    }

    //cài đặt sự phụ thuộc của Khoa với ngành
    function fetch(Request $request){
        $select = $request->get('select'); //Makhoa
        $value = $request->get('value'); //Makhoa--
        $dependent = $request->get('dependent'); //MaNganh
        $data = DB::table('nganhs')
                ->where('Khoas_MaKhoa', $value)
                ->get();
        $output = '<option value="%">Chọn ngành</option>';
        foreach ($data as $row) {
           $output .= '<option value="'.$row->MaNganh.'">'.$row->TenNganh.'</option>';
        }
        echo $output;
    }

    //Lấy danh sách các sinh viên đã có bảng điểm (cột isBD trong bảng sinh viên có value == 1)
    function sinhvienlist(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $MaNganh = $request->get('MaNganh');
            $MaKhoa = $request->get('MaKhoa');
            $MaSV = $request->get('MaSV'); //Ma sinh vien
            if($MaSV != '')
            {
                $data = DB::table('sinhviens')
                    ->join('nganhs', 'nganhs.MaNganh', '=', 'sinhviens.MaNganh')
                    ->join('khoas', 'khoas.MaKhoa', '=', 'sinhviens.MaKhoa')
                    ->where('MaSV', 'like', '%'.$MaSV.'%')
                    ->where('sinhviens.MaNganh', 'like', $MaNganh)
                    ->where('sinhviens.MaKhoa', 'like', $MaKhoa)
                    ->where('isBD', '=', '1')
                    ->get();
            }
            else
            {
                $data = DB::table('sinhviens')
                        ->join('nganhs', 'nganhs.MaNganh', '=', 'sinhviens.MaNganh')
                        ->where('isBD', '=', '1')
                        ->join('khoas', 'khoas.MaKhoa', '=', 'sinhviens.MaKhoa')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr>
                        <td>'.$row->MaSV.'</td>
                        <td>'.$row->TenSV.'</td>
                        <td>'.$row->TenKhoa.'</td>
                        <td>'.$row->TenNganh.'</td>
                        <td>K'.$row->Khoa.'</td>
                        <td class="action">
                            <a href="/bangdiem/'.$row->MaSV.'"class="add-mh btn btn-primary">Xem</a>
                         </td>
                    </tr>
                    ';
                }
            }
            else
            {
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
            'table_data'  => $output,
            'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }
    public function traoBang(Request $request){
        $MaSV = $request->MaSV;
        DB::table('danh_sach_chinh_thucs')->where('MaSV', $MaSV)->update(['TrangThai'=> 1]);
        return ['success' => true, 'message' => 'Đã trao bằng '.$MaSV.' thành công'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
