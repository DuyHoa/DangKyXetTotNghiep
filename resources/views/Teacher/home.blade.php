

@section('side-left')
	<div class="menu-block-1" id="menu-block-1">
		<p><b>Quản lý chương trình học</b></p>
		<ul>
			<li class="dropmenu-a">
				<a class="dropmenu-active">Quản lý Khoa</a>
				<ul class="dropmenu">
					<li>
						<a>Xem danh sách</a>
					</li>
					<li>
						<a href="{{URL('/khoa/create')}}">Thêm dữ liệu</a>
					</li>
				</ul>
			</li>
			<li class="dropmenu-a">
				<a class="dropmenu-active">Quản lý Ngành</a>
				<ul class="dropmenu">
					<li>
						<a>Xem danh sách</a>
					</li>
					<li>
						<a>Thêm dữ liệu</a>
					</li>
				</ul>
			</li>
			<li class="dropmenu-a">
				<a class="dropmenu-active">Quản lý môn học</a>
				<ul class="dropmenu">
					<li>
						<a>Xem danh sách</a>
					</li>
					<li>
						<a>Thêm dữ liệu</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<div class= "menu-block-1" id="menu-block-2">
		<p><b>Quản lý xét tốt nghiệp</b></p>
		<ul>
			<li class="dropmenu-a">
				<a class="dropmenu-active">Quản lý đợt xét tốt nghiệp</a>
				<ul class="dropmenu">
					<li>
						<a>Xem danh sách</a>
					</li>
					<li>
						<a>Thêm dữ liệu</a>
					</li>
				</ul>
			</li>
			<li class="dropmenu-a">
				<a class="dropmenu-active">Quản lý đợt hồ sơ</a>
				<ul class="dropmenu">
					<li>
						<a>Xem danh sách</a>
					</li>
					<li>
						<a>Thêm dữ liệu</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<div class= "menu-block-1" id="menu-block-3">
		<p><b>Quản lý Thông báo</b></p>
		<ul>
			<li class="dropmenu-a">
				<a class="dropmenu-active">Quản lý thông báo</a>
				<ul class="dropmenu">
					<li>
						<a>Xem danh sách</a>
					</li>
					<li>
						<a>Thêm dữ liệu</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
@endsection()