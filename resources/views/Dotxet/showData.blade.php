@extends('home')


@section('sub-title')
<div class="sub-title">
  <a>Danh sách sinh viên đăng ký đợt</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
  <a>Quản lý xét duyệt</a>
</div>
@endsection


@section('content')
<a href="/dotxet/list" class="btn btn-primary">Quay lại</a>
	<h3>Danh sách sinh viên đăng ký xét tốt nghiệp </h3>
<div class="dotxet-1">
	<table class="bangdiem-l">
	<tr> 
	      <th>Mã sinh viên</th>
	      <th>Tên sinh viên</th>
	      <th>Khoa</th>
	      <th>Ngành</th>
	      <th>Lớp</th>
	      <th>Hành động</th>
	</tr>
	@foreach($temp as $value)
	<tr>
		<td>{{ $value->MaSV }}</td>
		<td>{{ $value->TenSV }}</td>
		<td>{{ $value->TenKhoa }}</td>
		<td>{{ $value->TenNganh }}</td>
		<td>{{ $value->Lop }}</td>
		<td><a href="/xetduyet/{{ $value->MaNganh}}/{{ $value->MaSV }}" class="btn btn-success">Duyệt</a></td>
	</tr>
	@endforeach

	</table>
</div>
@endsection