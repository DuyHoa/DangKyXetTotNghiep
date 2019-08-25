@extends('home')


@section('content')
@if($message = Session::get('success'))
        <div class ="alert alert-success">
            <p>{{$message}}</p>
        </div>
        @endif
        @if($message = Session::get('remove'))
        <div class ="alert alert-warning">
            <p>{{$message}}</p>
        </div>
        @endif
        @if(count($errors) > 0)
         <div class ="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </div>
        @endif
<div><a class="add btn btn-success" href="{{URL('/khoa/create')}}">Thêm mới</a></div>
<div class="khoa-1">
	<table class="bangdiem-l">
	<tr>
	      <th>Mã Khoa</td>      
	      <th>Tên khoa</td>
	      <th>Hành động</td>
	</tr>
	@foreach($petani as $key => $datakhoa)
	    <tr>
	      <td>{{$datakhoa->MaKhoa}}</td>      
	      <td>{{$datakhoa->TenKhoa}}</td>
	      <td class="action">
	      	<a href="{{URL('/khoa/edit', $datakhoa->MaKhoa)}}" class="khoa-edit btn btn-info" id="{{$datakhoa->MaKhoa}}">Sửa</a>
	      	<form method ="POST" action="{{ URL('khoa/delete') }}" onSubmit="if(!confirm('Bạn thực sự muốn xóa Khoa: {{ $datakhoa->TenKhoa }}?')){return false;}">
	      	<!-- <form method ="POST" action="{{ URL('khoa/delete') }}" onSubmit="showDialog()" class="submit-del"> -->
	      		{{ csrf_field() }}
	      		<input type="hidden" name="MaKhoa" value="{{ $datakhoa->MaKhoa }}">
	      		<input type="submit" name="Delete"  value="Xóa" class="khoa-remove btn btn-warning">
	      	</form>	
	      </td>
	    </tr>
	@endforeach
	</table>
</div>
<script type="text/javascript">
$(document).ready(function(){
	function show_alert() {
		if(confirm("Do you really want to do this?"))
		    document.forms[0].submit();
		else
		    return false;
	}
});

$();

</script>

@endsection


@section('sub-title')
<div class="sub-title">
	<a>Danh sách các Khoa</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
	<a>Quản lý Khoa</a>
</div>
@endsection