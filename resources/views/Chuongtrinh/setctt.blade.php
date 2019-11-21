@extends('home')

@section('sub-title')
<div class="sub-title">
    <a>Tạo chương trình học</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
    <a>Quản lý Chương trình học</a>
</div>
@endsection

@section('content')
	@if (!empty($success))
    <div class ="alert alert-success">
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
<div class="setctth">
 <form action="{{ url('cth') }}" method="POST" role="form">
 	<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div class="form-group">
        <label for="">Chọn Khoa</label>
		<select name="Khoa" id="MaKhoa" class="form-control input-lg dynamic" data-dependent="MaNganh">
		   	<option value="">Chọn Khoa</option>
		    	@foreach(App\Khoa::all() as $key)
		    <option value="{{ $key->MaKhoa}}">{{ $key ->TenKhoa }}</option>
		 		@endforeach
		</select>
    </div>
    <div id="#MaNganh"></div>
    <div class="form-group">
        <label for="">Chọn ngành</label>
		<select name="Nganh" id="MaNganh" class="form-control input-lg dynamic" >
		   	<option value="">Chọn ngành</option>
		</select>
    </div>

    <div class="form-group">
        <label for="">Chọn Khóa</label>
		<select name="Khoas" id="cthkhoas" class="form-control input-lg dynamic">
		   	<option value="">NULL</option>
		    @foreach(App\course::all() as $key)
            <option value="{{ $key->course_code}}">{{ $key ->course_code }}</option>
            @endforeach
		</select>
    </div>

   <div class="form-group dc">
  		<output name="term" value="0"><strong>Chọn môn đại cương</strong></output>
  		<div class="mdc row">
	   		<div class="panel col-md-6">
	     		<div class="form-group">
	     			<div class="input-group">
	        			<span class="input-group-addon">Search</span>
	      				<input type="text" name="searchdc" id="searchdc" class="form-control" placeholder="Tìm kiếm dữ liệu môn học" />
	  				</div>
	     		</div>
	     		<div class="table-responsive">
	     			<table class="bangdiem-l">
	       				<thead>
	       				</thead>
	       				<tbody class="dct">

	       				</tbody>
	      			</table>
	     		</div>
	     	</div>
	     	<div class="panel col-md-6">
	     		<div class="form-group">
	     			<div class="input-group">
	        			<span class="input-group-addon">Search</span>
	      				<input type="text" name="searchdcct" id="searchdcct" class="form-control" placeholder="Tìm kiếm dữ liệu môn học" />
	  				</div>
	     		</div>
	     		<div class="table-responsive">
	     			<table class="bangdiem-l">
	       				<thead>
	       				</thead>
	       				<tbody class="dctct">

	       				</tbody>
	      			</table>
	     		</div>
	     	</div>
     	</div>
    </div>
    <div class=" general-status alert alert-info">
    	<p class="status"></p>
    </div>
   	<div class="form-group cn">
   		<output name="term" value="1"><strong>Chọn môn Chuyên ngành</strong></output>
   		<div class="mcn row">
	   		<div class="panel col-md-6">
	     		<div class="form-group">
	     			<div class="input-group">
	        			<span class="input-group-addon">Search</span>
	      				<input type="text" name="searchcn" id="searchcn" class="form-control" placeholder="Tìm kiếm dữ liệu môn học" />
	  				</div>
	     		</div>
	     		<div class="table-responsive">
	     			<table class="bangdiem-l">
	       				<thead>
	       				</thead>
	       				<tbody class="cnt">

	       				</tbody>
	      			</table>
	     		</div>
	     	</div>
	     	<div class="panel col-md-6">
	     		<div class="form-group">
	     			<div class="input-group">
	        			<span class="input-group-addon">Search</span>
	      				<input type="text" name="searchcnct" id="searchcnct" class="form-control" placeholder="Tìm kiếm dữ liệu môn học" />
	  				</div>
	     		</div>
	     		<div class="table-responsive">
	     			<table class="bangdiem-l">
	       				<thead>
	       				</thead>
	       				<tbody class="cntct">

	       				</tbody>
	      			</table>
	     		</div>
	     	</div>
     	</div>
	</div>
	<div class="form-group cn">
   		<output name="term" value="2"><strong>Chọn môn Chuyên ngành (tự chọn)</strong></output>
   		<div class="mcn row">
	   		<div class="panel col-md-6">
	     		<div class="form-group">
	     			<div class="input-group">
	        			<span class="input-group-addon">Search</span>
	      				<input type="text" name="searchcntc" id="searchcntc" class="form-control" placeholder="Tìm kiếm dữ liệu môn học" />
	  				</div>
	     		</div>
	     		<div class="table-responsive">
	     			<table class="bangdiem-l">
	       				<thead>
	       				</thead>
	       				<tbody class="cntc">

	       				</tbody>
	      			</table>
	     		</div>
	     	</div>
	     	<div class="panel col-md-6">
	     		<div class="form-group">
	     			<div class="input-group">
	        			<span class="input-group-addon">Search</span>
	      				<input type="text" name="searchcntcct" id="searchcntcct" class="form-control" placeholder="Tìm kiếm dữ liệu môn học" />
	  				</div>
	     		</div>
	     		<div class="table-responsive">
	     			<table class="bangdiem-l">
	       				<thead>
	       				</thead>
	       				<tbody class="cnctct">

	       				</tbody>
	      			</table>
	     		</div>
	     	</div>
     	</div>
	</div>
   <a class="btn btn-success" href="{{ URL('/chuongtrinhhoc') }}"> Quay lại</a>
</form>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function(){
	/*var myTimer = setInterval(function(){
  		setTimeout( function(){ XoaMonHoc(); }, 1000);
 	}, 500);*/
 	setTimeout( function(){
 		XoaMonHoc();
		a();
	} , 3000);
 	fetch_mh2ct_data();
  	fetch_mh1ct_data();
  	fetch_mh1_data();
	fetch_mh2_data();
	fetch_mh3_data()
  	$("#cthkhoas").change(function(){
  		var khoa = $("#MaKhoa option:selected").val();
 		var Nganh = $("#MaNganh option:selected").val();
 		var khoas = $("#cthkhoas option:selected").val();
 		fetch_mh2ct_data();
  		fetch_mh1ct_data();
  	})
 	function XoaMonHoc(){
	$(".del-mh").each(function(){
 		$(this).on("click", function(){
 			var khoa = $("#MaKhoa option:selected").val();
 			var Nganh = $("#MaNganh option:selected").val();
 			var khoas = $("#cthkhoas option:selected").val();
 			var Term = $(this).children("input[name=Term]").val();
 			var MaMon = $(this).children("input[name=MaMon]").val();
 			$.ajax({
 				type: "POST",url: "/cth/delete",
 				data:{
 					_token: $('meta[name=csrf-token]').attr('content'),
		 			MaMon: MaMon,
		 			Term: Term,
		 			Nganh: Nganh,
		 			khoa: khoa,
		 			khoas: khoas
 				},
 				success: function(message){
		 			$(".general-status").fadeIn("fast");
		 			$(".status").html(message);
		 			setTimeout(function(){
		 				$(".general-status").fadeOut("fast");
		 				$(".status").html(" ");
		 			}, 1000);
		 		},
		 		error:function(message){
		 			alert(message);
		 		},
 			})
 			fetch_mh2ct_data();
 			fetch_mh3ct_data();
  			fetch_mh1ct_data();
 		})})
	}
	
	
	/*queryAll(a);*/
	//querryDC();
	$("#MaKhoa").change(function(){
		if($(this).val != ''){
			var select = $(this).attr("id"); //Makhoa--MaNganh
			var value = $(this).val(); //Makhoa--
			var dependent = $(this).data('dependent'); //MaNganh
			var _token = $('input[name="_token"]').val();
			$.ajax({
				url: "{{ route('dynamicdependent.fetch') }}",
				method: "POST",
				data:{
					select:select,
					value: value,
					_token: _token,
					dependent: dependent,
				},
				success:function(result){
					$('#MaNganh').html(result);
				},
				error:function(mes){
					console.log(mes);
				}
			});
		}
	});
	function a(){
		$(".add-mh").each(function(){
	 		$(this).on("click", function(){
	 			var khoa = $("#MaKhoa option:selected").val();
	 			var Nganh = $("#MaNganh option:selected").val();
	 			var khoas = $("#cthkhoas option:selected").val();
	 			var Term = $(this).children("input[name=Term]").val();
	 			var TenMon = $(this).children("input[name=TenMon]").val();
	 			var MaMon = $(this).children("input[name=MaMon]").val();
	 			$.ajax({
	 				type: "POST",
	 				url: "/cth",
	 				data:{
	 					_token: $('meta[name=csrf-token]').attr('content'),
		 				MaMon: MaMon,
		 				TenMon: TenMon,
		 				Term: Term,
		 				Nganh: Nganh,
		 				khoa: khoa,
		 				khoas: khoas
		 			},
		 			success: function(message){
		 				$(".general-status").fadeIn("fast");
		 				$(".status").html(message);
		 				setTimeout(function(){
		 					$(".general-status").fadeOut("fast");
		 					$(".status").html(" ");
		 				}, 1000);
		 			},
		 			error:function(message){
		 				alert(message);
		 			}
	 			});
	 			fetch_mh2ct_data();
	 			fetch_mh3ct_data();
  				fetch_mh1ct_data();
	 		});
	 	});
	}
	
	function fetch_mh1_data(query = '')
 	{
  		$.ajax({
	   		url:"{{ route('cthdc.action') }}",
	   		method:'GET',
	   		data:{query:query},
	   		dataType:'json',
	   		success:function(data)
	   		{
	    		$('tbody.dct').html(data.table_data);
	   		}
  		})	
 	}
 	$(document).on('keyup', '#searchdc', function(){
	  	var query1 = $(this).val();
	  	fetch_mh1_data(query1);
	  	setTimeout( function(){ a(); }, 2000);
	 });
/* 	function queryAll(callback){
	 	$(document).on('keyup', '#searchdc', function(){
	  		var query1 = $(this).val();
	  		fetch_mh1_data(query1);
	 	});
	 	$(document).on('keyup', '#searchcn', function(){
	  		var query2 = $(this).val();
	  		fetch_mh2_data(query2);
	 	});
	 	setTimeout(function(){ callback(); }, 3000);
	}*/
 	function fetch_mh2_data(query = '')
 	{
  		$.ajax({
	   		url:"{{ route('cthcn.action') }}",
	   		method:'GET',
	   		data:{query:query},
	   		dataType:'json',
	   		success:function(data)
	   		{
	    		$('tbody.cnt').html(data.table_data);
	   		}
  		})
 	}
	 	$(document).on('keyup', '#searchcn', function(){
	  		var query2 = $(this).val();
	  		fetch_mh2_data(query2);
	  		setTimeout( function(){ a(); }, 2000);
	 	});

	function fetch_mh3_data(query = '')
 	{
  		$.ajax({
	   		url:"{{ route('cthcntc.action') }}",
	   		method:'GET',
	   		data:{query:query},
	   		dataType:'json',
	   		success:function(data)
	   		{
	    		$('tbody.cntc').html(data.table_data);
	   		}
  		})
 	}
	 	$(document).on('keyup', '#searchcntc', function(){
	  		var query3 = $(this).val();
	  		fetch_mh3_data(query3);
	  		setTimeout( function(){ a(); }, 2000);
	 	});
 	function fetch_mh1ct_data(query = '')
 	{
 		var khoa = $("#MaKhoa option:selected").val();
 		var Nganh = $("#MaNganh option:selected").val();
 		var khoas = $("#cthkhoas option:selected").val();
  		$.ajax({
	   		url:"{{ route('cthdcct.action') }}",
	   		method:'GET',
	   		data:{query:query, khoa:khoa, Nganh: Nganh, khoas: khoas},
	   		dataType:'json',
	   		success:function(data)
	   		{
	    		$('tbody.dctct').html(data.table_data);
	   		}
  		})
  		setTimeout( function(){ XoaMonHoc(); }, 2000);
 	}
 	$(document).on('keyup', '#searchdcct', function(){
  		var query1 = $(this).val();
  		fetch_mh1ct_data(query1);
  		/*clearInterval(myTimer);*/
  		setTimeout( function(){ XoaMonHoc(); }, 1000);
 	});
 	function fetch_mh2ct_data(query = '')
 	{
 		var khoa = $("#MaKhoa option:selected").val();
 		var Nganh = $("#MaNganh option:selected").val();
 		var khoas = $("#cthkhoas option:selected").val();
  		$.ajax({
	   		url:"{{ route('cthcnct.action') }}",
	   		method:'GET',
	   		data:{query:query, khoa:khoa, Nganh: Nganh, khoas: khoas},
	   		dataType:'json',
	   		success:function(data)
	   		{
	    		$('tbody.cntct').html(data.table_data);
	   		}
  		})
  		setTimeout( function(){ XoaMonHoc(); }, 3000);
 	}
 	$(document).on('keyup', '#searchcnct', function(){
  		var query2 = $(this).val();
  		fetch_mh2ct_data(query2);
  		/*clearInterval(myTimer);*/
  		setTimeout( function(){ XoaMonHoc(); }, 1000);
 	});
 	function fetch_mh3ct_data(query = '')
 	{
 		var khoa = $("#MaKhoa option:selected").val();
 		var Nganh = $("#MaNganh option:selected").val();
 		var khoas = $("#cthkhoas option:selected").val();
  		$.ajax({
	   		url:"{{ route('cthcntcct.action') }}",
	   		method:'GET',
	   		data:{query:query, khoa:khoa, Nganh: Nganh, khoas: khoas},
	   		dataType:'json',
	   		success:function(data)
	   		{
	    		$('tbody.cnctct').html(data.table_data);
	   		}
  		})
  		setTimeout( function(){ XoaMonHoc(); }, 3000);
 	}
 	$(document).on('keyup', '#searchcntcct', function(){
  		var query3 = $(this).val();
  		fetch_mh3ct_data(query3);
  		/*clearInterval(myTimer);*/
  		setTimeout( function(){ XoaMonHoc(); }, 1000);
 	});
});
</script>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
<style type="text/css">
	.general-status{
		display: none;
	}
</style>
@endsection


@section('fscript')
<script type="text/javascript">
 	
</script>
@endsection