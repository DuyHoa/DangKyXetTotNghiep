<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<script language=JavaScript> var txt="Trường đại học Thăng Long"; var espera=200; var refresco=null; function rotulo_title() { document.title=txt; txt=txt.substring(1,txt.length)+txt.charAt(0); refresco=setTimeout("rotulo_title()",espera); } rotulo_title();</SCRIPT>
	<link rel = "stylesheet" href="">
	<!-- Latest compiled and minified CSS -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->

	<!-- Optional theme -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->

	<!-- Latest compiled and minified JavaScript -->
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
	<link rel="stylesheet" href="{{ URL('/bootstrap-3/dist/css/bootstrap.min.css') }}"/>
	<link rel="stylesheet" href="{{ URL('/bootstrap-3/dist/css/bootstrap-theme.min.css') }}"/>
	<link rel="stylesheet" href="{{ URL('css/customstyle.css') }}">
	<link rel="stylesheet" href="{{ URL('/ionicons-2.0.1/css/ionicons.css') }}"/>
	<script type="text/javascript" scr="{{ URL('/bootstrap-3/dist/js/bootstrap.min.js') }}"></script>
	<script src="{{ URL('/ionicons-master/docs/ionicons.js') }}"></script>
	
	<script src="{{ URL('/jquery/1.11.1/jquery.min.js') }}"></script>
	<!-- <script src="https://unpkg.com/ionicons@4.2.2/dist/ionicons.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> -->
	<script src="{{ URL('js/myscript.js')}}"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div id="main-body">
					@yield('main-body')
				</div>
			</div>
		</div>
	</div>
</body>