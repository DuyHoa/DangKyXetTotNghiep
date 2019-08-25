@extends('home')

@section('banner-title')
<div class="banner-title">
	<a>Quản lý Khoa</a>
</div>
@endsection

@section('sub-title')
<div class="sub-title">
	<a>Sửa đổi Khoa</a>
</div>
@endsection



@section('content')
<div class="row">
	<div class="col-md-12">
		<div class = "form-in">
		@if(count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach($errors ->all() as $error)
					<li>{{$error}}</li>
				@endforeach
			</ul>
		</div>
		@endif
		<form method="post" action="{{URL::to('/khoa/update')}}">
			{{csrf_field()}}
			<div class="form-group">
				<label>Nhập mã của khoa</label>
				<input type="text" name="MaKhoa" class="form-control" placeholder="Nhập mã khoa" value="{{ $khoa->MaKhoa }}"/>
			</div>
			<div class="form-group">
				<label>Nhập tên của khoa</label>
				<input type="text" name="TenKhoa" class="form-control" placeholder="Nhập tên khoa" value="{{ $khoa->TenKhoa }}"/>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Xác nhận"/>
			</div>
		</form>
		</div>
	</div>
</div>

@endsection