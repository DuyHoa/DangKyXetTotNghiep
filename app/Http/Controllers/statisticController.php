<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\statistic;
use App\khoa;
use App\nganh;
use DB;

class statisticController extends Controller
{
    public function view(){
    	$year = statistic::groupBy('year')->get();
    	return view('thongke.thong-ke', ['year' => $year]);
    }
    public function fillData(Request $request){
    	$year = $request->year;
    	$output = '';
    	$count_mini = 0;
    	$array = '';
    	$data = statistic::where('year', $year)->get();
    	$cout_per = $data->sum('count');
    	if($data->count() == 0)
    		$output = 'Chưa có dữ liệu';
    	else{
    		foreach ($data as $key) {
    			$MN = nganh::where('MaNganh', $key->MaNganh)->value('TenNganh');
    			$MK = khoa::where('MaKhoa', $key->MaKhoa)->value('TenKhoa');
    			if(!(strstr($array, $MK)) && !(empty($output)) && $count_mini != 0){
    				$output .= '<tr class="bdresult-mini">
		    			<td></td>
		    			<td>------------------------</td>
		    			<td>'.$count_mini.'</td>
		    		</tr>';
		    		$count_mini = 0;
    			}
    			$output .= '
    			<tr>
    				<td class="name-left pf-25">'.$MN.'</td>
    				<td class="name-left">'.$MK.'</td>
    				<td>'.$key->count.'</td>
    			</tr>';
    			$array = $array.$MK." ";
    			$count_mini += $key->count;
    		}
    		$output .= '<tr class="">
		    			<td></td>
		    			<td>------------------------</td>
		    			<td></td>
		    		</tr>
		    <tr class="bdresult">
    			<td class="name-left pf-25">Tổng tất cả</td>
    			<td></td>
    			<td>'.$cout_per.'</td>
    		</tr>';
    	}
    	echo $output;
    }
    public function getMaKhoa(){
    	$b = khoa::orderBy('MaKhoa', 'asc')->get('MaKhoa');
    	return response()->json($b);
    }
    public function listAll(){
    	$b = khoa::get('MaKhoa');
    	$a = [];
    	$temp1 = new \stdClass();
    	$i = 0;
    	foreach ($b as $key) {
    		$c = $key['MaKhoa'];
    		array_push($a, $c);
    		$i++;
    	}
    	for ($i = 0; $i < count($a); $i++){
    		$temp = DB::table('statistics')->where('MaKhoa', $a[$i])->groupBy('year')->selectRaw('*, sum(count) as count')->orderBy('year', 'asc')->get();
    		$temp1 = $temp1->merge($temp);
    		echo ($a[$i]);
    	}
    	return response()->json($temp1);
    }
    public function listForKhoa($MaKhoa){
    	$perKhoa = statistic::where('MaKhoa', $MaKhoa)->groupBy('year')->selectRaw('*, sum(count) as count')->orderBy('year', 'asc')->get();
    	return response()->json($perKhoa);
    }
    public function listForYear($year){
    	$peryear = statistic::where('year', $year)->groupBy('MaKhoa')->selectRaw('*, sum(count) as count')->orderBy('year', 'asc')->get();
    	return response()->json($peryear);
    }
}
