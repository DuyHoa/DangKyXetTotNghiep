@extends('home')

@section('sub-title')
<div class="sub-title">
    <a>Quản lý môn thay thế</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
	<a>Quản lý môn học thay thế</a>
</div>
@endsection


@section('content')
<div class="col-sm-12">
	<div class="col-sm-7 col-sm-push-3 m-a">
	 	@if($message = Session::get('success'))
	    <div class ="alert alert-success">
	        <p>{{$message}}</p>
	    </div>
	    @endif
	    @if (!empty($success))
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


		<form action="{{ URL('/mh/thaythe') }}" method="POST" style="text-align: right;">
			{{ csrf_field() }}
			<div class="form-group dfex">
				<label for="MaMH" class="col-sm-7 row col-form-label">Mã môn:</label>
				<input type="text" name="MaMH" id="MaMH" placeholder="Nhập..." class="form-control"/>
			</div>
			<div class="form-group dfex">
				<label for="MaMTT" class="col-sm-7 row col-form-label">Mã môn thay thế:</label>
				<input type="text" name="MaMTT" id="MaMTT" placeholder="Nhập..." class="form-control"/>
			</div>
			<button class="btn btn-success">Xác nhận</button>
		</form>
	</div>
</div>
  <div class="dotxet-1">
  	<table class="bangdiem-l">
  		<tr>
  			<th>STT</th>
  			<th>Môn</th>
  			<th>Môn thay thế</th>
  			<th>Hành động</th>
  		</tr>
  		@foreach($tt as $value)
  		<tr>
  			<td>{{ $value->id }}</td>
  			<td>{{ $value->TenMon }} ({{ $value->MaMH }})</td>
  			<td>{{ $value->MaMTT }}</td>
  			<td class="action">
		      	<a href="{{URL('/mh/tt/edit', $value->id)}}" class="khoa-edit btn btn-info" id="{{ $value->id }}">Sửa</a>
		      	<form method ="POST" action="{{ URL('/mh/thaythe/delete') }}" onSubmit="if(!confirm('Bạn thực sự muốn xóa môn học: {{ $value->TenMon }}?')){return false;}">
		      		{{ csrf_field() }}
		      		<input type="hidden" name="id" value="{{ $value->id }}">
		      		<input type="submit" name="Delete"  value="Xóa" class="khoa-remove btn btn-warning">
		      	</form>	
		    </td>
	  	</tr>
	  @endforeach
  	</table>
  </div>

@endsection