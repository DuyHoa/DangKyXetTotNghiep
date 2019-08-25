<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<script language=JavaScript> 
		var txt="Trường đại học Thăng Long"; 
		var espera=200; var refresco=null; 
		function rotulo_title() { 
			document.title=txt; 
			txt=txt.substring(1,txt.length)+txt.charAt(0);
			refresco=setTimeout("rotulo_title()",espera);
		} 
		rotulo_title();
	</script>


	<link rel="stylesheet" href="{{ URL('/bootstrap-3/dist/css/bootstrap.min.css') }}"/>
	<link rel="stylesheet" href="{{ URL('/bootstrap-3/dist/css/bootstrap-theme.min.css') }}"/>
	<link rel="stylesheet" href="{{ URL('css/customstyle.css') }}">
    <link rel="stylesheet" href="{{ URL('/ionicons-2.0.1/css/ionicons.css') }}"/>

	<script type="text/javascript" scr="{{ URL('/bootstrap-3/dist/js/bootstrap.min.js') }}"></script>
	<script src="{{ URL('/ionicons-master/docs/ionicons.js') }}"></script>

	<script src="{{ URL('/jquery/1.11.1/jquery.min.js') }}"></script>
	<script src="{{ URL('js/myscript.js')}}"></script>
	@yield('script')

</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div id="header">
					<div id="main-menu">
						<div class="container">
							<div class="row">
								<ul class="main-menu">
									<li class="child logo-child">
										<a href="http://thanglong.edu.vn"></a>
									</li>
									<li>
										<a href="{{URL('/home')}}">Trang chủ</a>
									</li>
									<li>
										<a href="{{URL('/gioi-thieu')}}">Giới thiệu</a>
									</li>
									@if (Auth::check())
										<li class = "user-i">
											<a class = "logout-b">Hi, {{Auth::user()->name}}</a>
											<img src="/images/user.png" class="image-user"/>
											<ul class="logout-dropdown">
												<li><a class="logout-a" href="{{URL('/logout')}}">Đăng xuất</a></li>
											</ul>

										</li>		
									@endif
								</ul>	
							</div>
						</div>
					</div>
					<div id="banner">
						@yield('banner-title')
					</div>
				</div>
				<div id="content">
					<div class="container">
						<div class="row">
							<div class="side-left col-md-2">
								@yield('side-left')
							</div>
							<div class="main-content col-md-8">
								
								@yield('sub-title')
								@yield('content')
							</div>
							<div class="side-right col-md-2">
								<div class="side-right-general">
									<div class="side-right-level">
										<ion-icon name="star-outline"></ion-icon>
										@if (Auth::check())
											@if (Auth::user()->level == 1)
											<div class="user-level-admin">
												Admin
											</div>
											@elseif (Auth::user()->level == 2)
											<div class="user-level-teacher">
												Phòng đào tạo
											</div>
											@elseif (Auth::user()->level == 3)
											<div class="user-level-student">
												Sinh viên
											</div>
											@endif
										@endif
									</div>
									<div class="side-right-img">
										<img src="/images/user.png"/>
									</div>
									<div class="side-right-infor">
										<div class="user-msv">
											<ion-icon name="school"></ion-icon>
											{{ Auth::user()->MaSV }}
										</div>
										<div class="user-name">
											<ion-icon name="contact"></ion-icon>
											{{Auth::user()->name}}
										</div>
										<div class="user-email">
											<ion-icon name="mail"></ion-icon>
											{{Auth::user()->email}}
										</div>
										
									</div>
								</div>							
							</div>
						</div>
					</div>
				</div>
				<div id="footer">
					<div class="container">
						<div class="row">
							<div class="main-footer">
								<div class="contact-info col-md-5">
									<div class="title-info">
										<div class="logo-footer">
											<img src="{{URL('/images/logo.png')}}">
										</div>
										<h3 class="titlef">Trường Đại học Thăng Long</h3>
									</div>
									<div class="main-info">
										<ul>
											<li>
												<ion-icon name="home"></ion-icon>
												<a>Đường Nghiêm Xuân Yêm - Đại Kim - Hoàng Mai - Hà Nội</a>
											</li>
											<li>
												<ion-icon name="call"></ion-icon>
												<a>(84-24) 38 58 73 46 </a>
											</li>
											<li>
												<ion-icon name="print"></ion-icon>
												<a>(84-24) 35 63 67 75 </a>
											</li>
											<li>
												<ion-icon name="mail"></ion-icon>
												<a>info@thanglong.edu.vn</a>
											</li>
											<li>
												<ion-icon name="mail"></ion-icon>
												<a>hopthugopy@thanglong.edu.vn</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="map-info col-md-4">
									<h3>Bản đồ</h3>
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.4063626573584!2d105.81252471493175!3d20.97634188602682!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135acef8135182f%3A0x2a11098b8ca90ce6!2zVHLGsOG7nW5nIMSQSCBUaMSDbmcgTG9uZw!5e0!3m2!1svi!2s!4v1557294943723!5m2!1svi!2s" width="300" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
								</div>
								<div class="member-info col-md-3">
									<h3>Create by</h3>
									<ul>
										<li>
											<ion-icon name="paw"></ion-icon>
											<a href="https://www.facebook.com/hoa.nguyenduy.359">Nguyễn Duy Hòa</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="coppy-right">
						<p>Copyright © 2019 Đại Học Thăng Long</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
@yield('fscript')