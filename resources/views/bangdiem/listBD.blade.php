@extends('bangdiem.getbangdiem')

@section('script')
<div class="bangdiem-l">
	<table>
	<tr>
	      <td>Mã sinh viên</td>      
	      <td>Mã môn</td>
	      <td>Tên môn</td>
	      <td>Tín chỉ</td>
	      <td>Điểm</td>
	</tr>
	@foreach($petani as $key => $data)
	    <tr>
	      <td>{{$data->SinhViens_MaSV}}</td>      
	      <td>{{$data->MaMH}}</td>
	      <td>{{$data->TenMH}}</td>
	      <td>{{$data->SoTC}}</td>
	      <td>{{$data->Diem}}</td>
	    </tr>
	@endforeach
	</table>
</div>
@endsection