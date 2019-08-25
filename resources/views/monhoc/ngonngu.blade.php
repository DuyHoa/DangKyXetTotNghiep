@extends('home')


@section('sub-title')
<div class="sub-title">
    <a>Quản lý ngôn ngữ 2</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
	<a>Quản lý Ngoại ngữ 2</a>
</div>
@endsection


@section('content')
<div class="col-sm-12">
	<div class="col-sm-6 col-sm-push-3 m-a">
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
		<form action="{{ URL('/mh/nn2') }}" method="POST" style="text-align: right;">
			{{ csrf_field() }}
			<div class="form-group dfex">
				<label for="MaMon" class="col-sm-6 row col-form-label">Mã môn:</label>
				<input type="text" name="MaMon" id="MaMon" placeholder="Nhập..." class="form-control"/>
			</div>
			<div class="form-group dfex">
				<label for="TenMon" class="col-sm-6 row col-form-label">Tên môn:</label>
				<input type="text" name="TenMon" id="TenMon" placeholder="Nhập..." class="form-control"/>
			</div>
			<div class="form-group dfex">
				<label for="Loai"class="col-sm-6 row col-form-label" >Loại:</label>
				<select name="Loai" id="Loai" class="form-control">
					<option value="NN1">Ngôn ngữ 1</option>
					<option value="NN2">Ngôn ngữ 2</option>
				</select>
			</div>
			<button class="btn btn-success">Xác nhận</button>
		</form>
	</div>
</div>
  <div class="dotxet-1">
  	<table class="bangdiem-l">
  		<tr>
  			<th>STT</th>
  			<th>Mã Môn</th>
  			<th>Tên Môn</th>
  			<th>Thuộc nhóm</th>
  			<th>Hành động</th>
  		</tr>
  		@foreach($nn as $value)
  		<tr>
  			<td>{{ $value->id }}</td>
  			<td>{{ $value->MaMon }}</td>
  			<td>{{ $value->TenMon }}</td>
  			<td>{{ $value->Loai }}</td>
  			<td class="action">
		      	<a href="{{URL('/mh/nn2/edit', $value->MaMon)}}" class="khoa-edit btn btn-info" id="{{$value->MaMon}}">Sửa</a>
		      	<form method ="POST" action="{{ URL('/mh/nn2/delete') }}" onSubmit="if(!confirm('Bạn thực sự muốn xóa môn học: {{ $value->TenMon }}?')){return false;}">
		      		{{ csrf_field() }}
		      		<input type="hidden" name="MaMon" value="{{ $value->MaMon }}">
		      		<input type="submit" name="Delete"  value="Xóa" class="khoa-remove btn btn-warning">
		      	</form>	
		    </td>
	  	</tr>
	  @endforeach
  	</table>
  </div>

@endsection