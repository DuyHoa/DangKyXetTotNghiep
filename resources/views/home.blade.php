@extends('master')

@if (Auth::check())
@section('side-left')
	@if( Auth::user()->level == 1)
		<!--Null-->
	@elseif( Auth::user()->level == 2)
		<div class="menu-block-1" id="menu-block-1">
			<p><b>Quản lý chương trình học</b></p>
			<ul>
				<li class="dropmenu-a">
					<a href="{{URL('/khoa/list')}}" class="dropmenu-active">Quản lý Khoa</a>
				</li>
				<li class="dropmenu-a">
					<a href="{{URL('/nganh/list')}}" class="dropmenu-active">Quản lý Ngành</a>
				</li>
				<li class="dropmenu-a">
					<a href="{{URL('/monhoc/list')}}" class="dropmenu-active">Quản lý môn học</a>
				</li>
				<li class="dropmenu-a">
					<a href="{{URL('/mh/nn2')}}" class="dropmenu-active">Quản lý ngoại ngữ 2</a>
				</li>
				<li class="dropmenu-a">
					<a href="{{URL('/mh/thaythe')}}" class="dropmenu-active">Quản lý môn thay thế</a>
				</li>
				<li class="dropmenu-a">
					<a href="{{URL('/chuongtrinhhoc')}}" class="dropmenu-active">Tạo chương trình học</a>
				</li>
			</ul>
		</div>
		<div class="menu-block-1" id="menu-block-1">
			<p><b>Quản lý Bảng điểm</b></p>
			<ul>
				<li class="dropmenu-a">
					<a href="{{URL('/sinhvien/list')}}" class="dropmenu-active">Quản lý Sinh viên</a>
				</li>
			</ul>
		</div>
		<div class= "menu-block-1" id="menu-block-2">
			<p><b>Quản lý xét tốt nghiệp</b></p>
			<ul>
				<li class="dropmenu-a">
					<a href="{{URL('/dotxet/list')}}" class="dropmenu-active">Quản lý đợt xét tốt nghiệp</a>
				</li>
				<li class="dropmenu-a">
					<a class="dropmenu-active" href= "{{ URL('/xetduyet/caidat') }}">Cài đặt điều kiện</a>
				</li>
				<li class="dropmenu-a">
					<a class="dropmenu-active" href="{{ URL('/list/dukien') }}">Danh sách dự kiến</a>
				</li>
				<li class="dropmenu-a">
					<a class="dropmenu-active" href= "{{ URL('/list/chinhthuc') }}">Danh sách chính thức</a>
				</li>
				<li class="dropmenu-a">
					<a class="dropmenu-active" href= "{{ URL('/list/huy') }}">Danh sách loại</a>
				</li>
			</ul>
		</div>
		<div class= "menu-block-1" id="menu-block-3">
			<p><b>Quản lý Thông báo</b></p>
			<ul>
				<li class="dropmenu-a">
					<a class="dropmenu-active null">Quản lý thông báo</a>
				</li>
			</ul>
		</div>
		<div class= "menu-block-1" id="menu-block-4">
			<p><b>Thống kê</b></p>
			<ul>
				<li class="dropmenu-a">
					<a class="dropmenu-active" href="{{ URL('/thong-ke') }}">Báo cáo</a>
				</li>
			</ul>
		</div>
	@elseif( Auth::user()->level == 3)
		<div class="menu-block-1" id="menu-block-1">
			<p><b>Chọn đợt tốt nghiệp</b></p>
			<ul>
				<li>
					<a href="{{ URL('/dangky') }}">Đăng ký xét tốt nghiệp</a>
				</li>
			</ul>
		</div>
		<div class= "menu-block-1" id="menu-block-2">
			<p><b>Xem thông báo</b></p>
			<ul>
				<li dropmenu-a>
					<a>Xem danh sách</a>
				</li>
			</ul>
		</div>
		<div class= "menu-block-1" id="menu-block-3">
			<p><b>Xét tốt nghiệp chính thức</b></p>
			<ul>
				<li class="dropmenu-a">
					<a href="{{ URL('/danh-sach') }}">Xem danh sách</a>
				</li>
			</ul>
		</div>		
	@endif
@endsection()
@endif


@section('content')
<div class="gioithieu">
	
	<!-- <img src=""/>
	<p><i>Sơ đồ UC của hệ thống</i></p> -->
</div>
@endsection

@section('sub-title')
<div class="sub-title">
	<a>Welcome! {{ Auth::user()->name }}</a>
</div>
@endsection

@section('user-block')
<div class="user-block-1">
	<div class="user-block-1-img">
		<div class="user-block-1-img-outline">
			<img src="/images/user.png" class="user-block-1-img-inline"/>
		</div>
	</div>
	<div class="user-block-1-name">
		<div class="user-block-1-name-outline">
			@if (Auth::check())
				<a class="user-block-1-name-inline">{{Auth::user()->name}}</a>
			@endif
		</div>
	</div>
	<div class="user-block-1-logout">
		<div class="user-block-1-logout-outline">
			<img src="/images/logout-2.png" class="user-block-1-logout-inline"/>
			<a class="user-logout" href="{{URL('/logout')}}">Đăng xuất</a>
		</div>
	</div>
</div>
@endsection

@section('banner-title')
<div class="banner-image">
	<img src="/images/Welcome.png"/>
</div>
@endsection