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
	<script src="{{ URL('/dataTables/jquery.dataTable.min.js') }}" type="text/javascript"></script>
	<script src="{{ URL('/canvasjs/jquery.canvasjs.min.js') }}" type="text/javascript"></script>
	<script src="{{ URL('/ChartJS/Charts.js') }}" type="text/javascript"></script>
	<script src="{{ URL('js/myscript.js')}}"></script>
	@yield('script')

</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="ads">
				<div class="ads-side-right">
					<div class="ads-side-right-top"></div>
					<div class="ads-side-right-center">
						<div class="ads-side-right-center-info"></div>
						<div class="side-right">
							<div class="side-right-general">
								<div class="side-right-level">
									<ion-icon name="star-outline"></ion-icon>
									@if (Auth::check())
										@if (Auth::user()->level == 1)
											<div class="user-level-admin">Admin</div>
										@elseif (Auth::user()->level == 2)
											<div class="user-level-teacher">Phòng đào tạo</div>
										@elseif (Auth::user()->level == 3)
											<div class="user-level-student">Sinh viên</div>
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
					<div class="ads-side-right-bottom"></div>
				</div>
			</div>
			<div class="menu-bar-side-left-fixed col-md-2 col-md-pull-10">
				<div class="side-left">
					<div  class="user-block">
						@yield('user-block')
					</div>
					<div class="menu-block">
						@yield('side-left')
					</div>
				</div>
			</div>
			<div class="main-body col-md-10">
				<div id="popup">
					<div class="popup-null">
						<div class="popup-null-head">
							<p class="popup-null-head-content">Thông báo</p>
						</div>
						<div class="popup-null-main">
							<p class="popup-null-main-content">Chức năng tạm thời chưa update</p>
							<a class="popup-null-main-button popup-button-close">Đóng</a>
						</div>
					</div>
				</div>
				<div id="popup-list">
					<div class="popup-list">
						<div class="popup-list-head"></div>
						<div class="popup-list-main"></div>
					</div>
				</div>
				<div id="popup-alert">
					<div class="popup-alert">
						<div class="popup-alert-head"></div>
						<div class="popup-alert-main"></div>
					</div>
				</div>
				<div id="main-menu">
						<div class="container">
							<div class="row">
								<ul class="main-menu">
									<li class="child logo-child">
										<a class="menu-logo-side-left"></a>
									</li>
									<li class="to-home">
										<a href="{{URL('/home')}}">Trang chủ</a>
									</li>
									<li class="to-about">
										<a href="{{URL('/gioi-thieu')}}">Giới thiệu</a>
									</li>
									<li class="to-search">
										<div class="search-form">
											<input type="text" class="search" placeholder="Nhập để tìm kiếm"/>
											<a class="submit-search null"></a>
										</div>
									</li>
								</ul>	
							</div>
						</div>
					</div>
				<div id="header">
					<!--menuold-->

					<div id="banner">
						@yield('banner-title')
					</div>
				</div>
				<div id="content">
					<div class="container">
						<div class="row">
							<!-- old menu -->
							<div class="main-content col-md-12">
								@yield('sub-title')
								@yield('content')
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
									<!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.4063626573584!2d105.81252471493175!3d20.97634188602682!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135acef8135182f%3A0x2a11098b8ca90ce6!2zVHLGsOG7nW5nIMSQSCBUaMSDbmcgTG9uZw!5e0!3m2!1svi!2s!4v1557294943723!5m2!1svi!2s" width="300" height="250" frameborder="0" style="border:0" allowfullscreen></iframe> -->
								</div>
								<div class="member-info col-md-3">
									<h3>Support</h3>
									<div class="support-footer">
										<a class="null">Facebook</a>
										<a class="null">Hotline</a>
										<a class="null">Skype</a>
										<a class="null">Zalo</a>
									</div>
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
<script type="text/javascript">
  $(".null").on("click", function(){
    if($("#popup").is(":hidden")){
      $("#popup").css("display","block");
    }
  })
  $(".popup-button-close").on("click",function(){
    if($("#popup").is(":visible")){
      $("#popup").fadeOut();
    }
  })

  $(".ads-side-right-center-info").on("click", function(){
  	var this_s = $(this)
  	var imgOn = "turnOn-infor-side-right";
  	var imgOff = "turnOff-infor-side-right";
  	if(!this_s.hasClass(imgOff) && !this_s.hasClass(imgOn)){
  		this_s.addClass(imgOn);
  		this_s.removeClass(imgOff);
  		$(".ads-side-right-center").css("right", "0");	
  	}
  	else if(this_s.hasClass(imgOn)){
  		this_s.addClass(imgOff);
  		this_s.removeClass(imgOn);
  		$(".ads-side-right-center").css("right", "-217px");	
  	}
  	else{
  		this_s.addClass(imgOn);
  		this_s.removeClass(imgOff);
  		$(".ads-side-right-center").css("right", "0");	
  	}
  })

  $(".menu-logo-side-left").on("click", function(){
  	var menuLeftCls = $(".menu-bar-side-left-fixed");
  	var bodyMainCls = $(".main-body");
  	var colMd12 = "col-md-12";
  	var colMdPull12 = "col-md-pull-12"
  	var menuPull = "col-md-pull-10";
  	var bodyPush = "col-md-10";

  	if(bodyMainCls.hasClass("closed")){
  		menuLeftCls.addClass(menuPull).removeClass(colMdPull12);
  		bodyMainCls.addClass(bodyPush).removeClass(colMd12);
  		/*menuLeftCls.css("left", '-300px');*/
  		bodyMainCls.removeClass("closed");
  	}
  	else{
  		menuLeftCls.removeClass(menuPull).addClass(colMdPull12);
  		bodyMainCls.addClass(colMd12).removeClass(bodyPush);
  		/*menuLeftCls.css("left", '0');*/
  		bodyMainCls.addClass("closed");
  	}
  })

  $(".to-about").on("click", function(){
  	location.href="{{URL('/gioi-thieu')}}";
  })
  $(".to-home").on("click", function(){
  	location.href="{{URL('/home')}}";
  })
  // Change the selector if needed

</script>
