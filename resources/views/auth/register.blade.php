@extends('login')
@section('title','Trang quản lý')
@section('main-body')
<?php //Hiển thị thông báo thành công?>
@if ( Session::has('success') )
	<div class="alert alert-success alert-dismissible" role="alert">
		<strong>{{ Session::get('success') }}</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
	</div>
@endif
<?php //Hiển thị thông báo lỗi?>
@if ( Session::has('error') )
	<div class="alert alert-danger alert-dismissible" role="alert">
		<strong>{{ Session::get('error') }}</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
	</div>
@endif
@if ($errors->any())
	<div class="alert alert-danger alert-dismissible" role="alert">
		<ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
	</div>
@endif
<div class="container" style="margin-top: 10%">
	<div class="row">
		<div class="col-sm-6 col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">ĐĂNG KÝ THÀNH VIÊN</h4>
				</div>
				<div class="panel-body">
					<form role="form" method="POST" action="{{ url('/register') }}">
						{!! csrf_field() !!}
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input class="form-control" placeholder="Họ và tên" name="name" type="text" value="{{ old('name') }}" autofocus>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-education"></i></span>
								<input class="form-control" placeholder="Mã sinh viên" name="MaSV" type="text" value="{{ old('MaSV') }}">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<input class="form-control" placeholder="Email" name="email" type="text" value="{{ old('email') }}">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">		
								<span class="input-group-addon"><i class="glyphicon glyphicon-sunglasses"></i></span>
								<select name="level" id="level-us" class="form-control input-lg dynamic" data-dependent="state">
	                				<option value="">------------</option>
	                				<option value="2">Phòng đào tạo</option>
									<option value="3">Sinh viên</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input class="form-control" placeholder="Mật khẩu" name="password" type="password">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input class="form-control" placeholder="Xác nhận mật khẩu" name="password_confirmation" type="password">
							</div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-lg btn-primary btn-block">Đăng ký</button>
						</div>
						<center><a href="{{ url('/login') }}">Quay về đăng nhập</a></center>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
body{
	background: url("/images/background-1.png");
}
.panel{
	border-radius: 5px;
}
.panel-heading {
    padding: 10px 15px;
}
.panel-title{
	text-align: center;
	font-size: 15px;
	font-weight: bold;
	color: #17568C;
}
.panel-footer {
	padding: 1px 15px;
	color: #A0A0A0;
}
.profile-img {
	width: 120px;
	height: 120px;
	margin: 0 auto 10px;
	display: block;
	-moz-border-radius: 50%;
	-webkit-border-radius: 50%;
	border-radius: 50%;
}
</style>
@endsection