<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SearchMonHoc extends Controller
{
    function index()
    {
    	return view('Chuongtrinh.setcth');
    }

    function daicuong(Request $request)
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
        			->orderBy('TenMon', 'ASC')
        			->get();
      		}
      		else
      		{
       			$data = DB::table('monhocs')
         				->get();
      		}
      		$total_row = $data->count();
      		if($total_row > 0)
      		{
       			foreach($data as $row)
       			{
		        	$output .= '
		        	<tr>
		         		<td></td>
		         		<td><output name="TenMon" value="'.$row->TenMon.'">'.$row->TenMon.'('.$row->MaMon.')</output></td>
		         		<td class="action">
					      	<a class= "add-mh glyphicon glyphicon-plus">
                  <input type="hidden" name="Term" value="0"></output>
                  <input type="hidden" name="TenMon" value="'.$row->TenMon.'"></output>
                  <input type="hidden" name="MaMon" value="'.$row->MaMon.'"></output>
                  </a>
					     </td>
		        	</tr>
		        	';
	       		}
      		}
      		else
      		{
	       		$output = '
	       		<tr>
	        		<td align="center" colspan="2">No Data Found</td>
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

    function chuyennganh(Request $request)
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
        			->orderBy('TenMon', 'ASC')
        			->get();
      		}
      		else
      		{
       			$data = DB::table('monhocs')
         				->get();
      		}
      		$total_row = $data->count();
      		if($total_row > 0)
      		{
       			foreach($data as $row)
       			{
		        	$output .= '
		        	<tr>
		         		<td></td>
		         		<td><output name="TenMon" value="'.$row->TenMon.'">'.$row->TenMon.'('.$row->MaMon.')</output></td>
		         		<td class="action">
					      	<a class= "add-mh glyphicon glyphicon-plus">
                  <input type="hidden" name="Term" value="1"/>
                  <input type="hidden" name="TenMon" value="'.$row->TenMon.'"/>
                  <input type="hidden" name="MaMon" value="'.$row->MaMon.'"/>
                  </a>
					     </td>
		        	</tr>
		        	';
	       		}
      		}
      		else
      		{
	       		$output = '
	       		<tr>
	        		<td align="center" colspan="2">No Data Found</td>
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
