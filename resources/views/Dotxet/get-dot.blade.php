@extends('home')

@section('sub-title')
<div class="sub-title">
  <a>Danh sách đợt xét</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
  <a>Quản lý đợt xét</a>
</div>
@endsection

@section('content')
@if($message = Session::get('success'))
    <div class ="alert alert-success">
        <p>{{$message}}</p>
    </div>
@endif
@if($message = Session::get('info'))
    <div class ="alert alert-info">
        <p>{{$message}}</p>
    </div>
@endif
@if($message = Session::get('remove'))
    <div class ="alert alert-warning">
        <p>{{$message}}</p>
    </div>
@endif
@if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors ->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="add" style="padding-bottom: 10px;"><a class="btn btn-success" href="{{URL('/dotxet/create')}}">Thêm mới</a></div>
<div class="dotxet-1">
	<table class="bangdiem-l">
	<tr> 
		<th>Mã Đợt</th>
	    <th>Tên đợt xét</th>
	    <th>Trạng thái</th>
	    <th>Ngày bắt đầu</th>
	    <th>Ngày kết thúc</th>
	    <th>Hành động</th>
	</tr>
	@foreach($dotxet as $key => $dotxet)
	    <tr>  
	      <td>{{$dotxet->MaDX}}</td>
	      <td>{{$dotxet->TenDX}}</td>
	      <td>
	      @if($dotxet->Status == 1)
	      <div class="status-dx-on">
	      	<strong>Hoạt động</strong>
	  	  </div>
	  	  @elseif($dotxet->Status == 0)
	  	  <div class="status-dx-off">
	      	<strong>Hết hạn</strong>
	  	  </div>
	  	  @endif
	      </td>
	  	  <td>{{$dotxet->NgayBatDau}}</td>
	  	  <td>{{$dotxet->NgayKetThuc}}</td>
	      <td class="action">
	      	<a href="{{URL('/dotxet/edit', $dotxet->MaDX)}}" class="khoa-edit btn btn-info" id="{{$dotxet->MaDX}}">Sửa</a>
	      	<form method ="POST" action="{{ URL('dotxet/delete') }}" onSubmit="if(!confirm('Bạn thực sự muốn xóa đợt xét: {{ $dotxet->TenDX }}?')){return false;}">
	      		{{ csrf_field() }}
	      		<input type="hidden" name="MaDX" value="{{ $dotxet->MaDX }}">
	      		<input type="submit" name="Delete"  value="Xóa" class="khoa-remove btn btn-warning">
	      	</form>
	      	<a href="{{URL('/dotxet', $dotxet->MaDX)}}" class="khoa-edit btn btn-danger">Xem</a>
	      </td>
	    </tr>
	@endforeach
	</table>
</div>
@endsection