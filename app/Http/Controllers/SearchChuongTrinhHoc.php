<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SearchChuongTrinhHoc extends Controller
{
    function daicuong(Request $request)
    {
    	if($request->ajax())
    	{
    		$output = '';
    		$query = $request->get('query');
        $nganh = $request->get('Nganh');
        $khoa = $request->get('khoa');
        $khoas = $request->get('khoas');
    		if($query != '')
    		{
    			$data = DB::table('chuong_trinh_hocs')
              ->where('Term', '=', '0')
    				  ->where('MaMon', 'like', '%'.$query.'%')
        			->orWhere('TenMon', 'like', '%'.$query.'%')
        			->orderBy('TenMon', 'ASC')
              ->Where('Nganh','=',$nganh)
              ->Where('khoa','=',$khoa)
              ->Where('khoas','=',$khoas)
        			->get();
      		}
      		else
      		{
       			$data = DB::table('chuong_trinh_hocs')
                ->where('Term', '=', '0')
                ->Where('Nganh','=',$nganh)
                ->Where('khoa','=',$khoa)
                ->Where('khoas','=',$khoas)
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
                  <a class="glyphicon glyphicon-minus del-mh">
                    <input type="hidden" name="Term" value="'.$row->Term.'"/>
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

    function chuyennganh(Request $request)
    {
    	if($request->ajax())
    	{
    		$output = '';
    		$query = $request->get('query');
        $nganh = $request->get('Nganh');
        $khoa = $request->get('khoa');
        $khoas = $request->get('khoas');
    		if($query != '')
    		{
    			$data = DB::table('chuong_trinh_hocs')
              ->where('Term', '=', 1)
              ->Where('Nganh','=',$nganh)
              ->Where('khoa','=',$khoa)
              ->Where('khoas','=',$khoas)
    				  ->where('MaMon', 'like', '%'.$query.'%')
        			->orWhere('TenMon', 'like', '%'.$query.'%')
        			->orderBy('TenMon', 'ASC')
        			->get();
      		}
      		else
      		{
       			$data = DB::table('chuong_trinh_hocs')
                ->where('Term', '=', 1)
                ->Where('Nganh','=',$nganh)
                ->Where('khoa','=',$khoa)
                ->Where('khoas','=',$khoas)
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
					      	<a class="glyphicon glyphicon-minus del-mh">
                    <input type="hidden" name="Term" value="'.$row->Term.'"/>
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
    function chuyennganhtc(Request $request)
    {
      if($request->ajax())
      {
        $output = '';
        $query = $request->get('query');
        $nganh = $request->get('Nganh');
        $khoa = $request->get('khoa');
        $khoas = $request->get('khoas');
        if($query != '')
        {
          $data = DB::table('chuong_trinh_hocs')
              ->where('Term', '=', 2)
              ->Where('Nganh','=',$nganh)
              ->Where('khoa','=',$khoa)
              ->Where('khoas','=',$khoas)
              ->where('MaMon', 'like', '%'.$query.'%')
              ->orWhere('TenMon', 'like', '%'.$query.'%')
              ->orderBy('TenMon', 'ASC')
              ->get();
          }
          else
          {
            $data = DB::table('chuong_trinh_hocs')
                ->where('Term', '=', 2)
                ->Where('Nganh','=',$nganh)
                ->Where('khoa','=',$khoa)
                ->Where('khoas','=',$khoas)
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
                  <a class="glyphicon glyphicon-minus del-mh">
                    <input type="hidden" name="Term" value="'.$row->Term.'"/>
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
