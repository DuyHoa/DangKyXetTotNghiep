<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\monhoc;

class LiveSearch extends Controller
{
    function index()
    {
    	return view('monhoc.get-subject');
    }

    function action(Request $request)
    {
    	if($request->ajax())
    	{
    		$output = '';
    		$query = $request->get('query');
    		if($query != '')
    		{
    			$data = DB::table('monhocs')
    				->where('MaMon', 'like', '%'.$query.'%')
        			->orWhere('TenMon', 'like', '%'.$query.'%')
        			->orWhere('TinChi', 'like', '%'.$query.'%')
        			->orderBy('MaMon', 'ASC')
        			->get();
      		}
      		else
      		{
       			$data = DB::table('monhocs')
              ->orderBy('MaMon', 'ASC')
              ->get();;
      		}
      		$total_row = $data->count();
      		if($total_row > 0)
      		{
       			foreach($data as $row)
       			{
		        	$output .= '
		        	<tr>
		         		<td>'.$row->MaMon.'</td>
		         		<td>'.$row->TenMon.'</td>
		         		<td>'.$row->TinChi.'</td>
		         		<td class="action">
					      	<a href="/monhoc/edit/'.$row->MaMon.'" class="khoa-edit btn btn-info">Sửa</a>
					      	<form method ="POST" action="/monhoc/delete" onSubmit="if(!confirm(\'Bạn thực sự muốn xóa Môn học: '.$row->TenMon.'?\')){return false;}">
					      		<input class="abctest" type="hidden" name="_token">
					      		<script type="text/javascript">
					      			var csrfVar = $("meta[name=\'csrf-token\']").attr("content");
					      			$("input[name=\'_token\']").val(csrfVar);
					      		</script>
					      		<input type="hidden" name="MaMon" value="'.$row->MaMon.'">
					      		<input type="submit" name="Delete"  value="Xóa" class="khoa-remove btn btn-warning">
					      	</form>
					     </td>
		        	</tr>
		        	';
	       		}
      		}
      		else
      		{
	       		$output = '
	       		<tr>
	        		<td align="center" colspan="4">No Data Found</td>
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
}
