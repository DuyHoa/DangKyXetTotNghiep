@extends('master')

@if (Auth::check())
	<div>
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
							<a class="dropmenu-active">Quản lý thông báo</a>
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
	</div>
@endif


@section('content')
<div class="gioithieu">
	<p>Trong nhiều năm qua, trường Đại học Thăng Long đã và đang được mở rộng quy mô khoa học, ngành học. Đi kèm với sự phát triển đào tạo của nhà trường, số lượng và chất lượng sinh viên tốt nghiệp hàng năm ngày càng cao. Nhưng nghiệp vụ xét tuyển đăng ký tốt nghiệp đang gặp tình trạng khó khăn bởi hiện tại Phòng đào tạo dừng lại việc xét duyệt qua sổ sách thủ công. Điều này gây khó khăn đối với những người đang thực hiện nghiệp vụ này.</p>
	<p>Trải qua một thời gian tìm hiểu, nhóm sinh viên chúng tôi đã quyết định thực hiện phát triển phần mềm “Hệ thống quản lí đăng ký xét tốt nghiệp”. Mục tiêu của hệ thống nhằm giải quyết bài toán tồn đọng trong việc xét duyệt tốt nghiệp thủ công và quản lí dữ liệu sinh viên.</p>
	<img src="/images/uc.jpg"/>
	<p><i>Sơ đồ UC của hệ thống</i></p>
</div>
@endsection

@section('sub-title')
<div class="sub-title">
	<a>Giới thiệu phần mềm</a>
</div>
@endsection