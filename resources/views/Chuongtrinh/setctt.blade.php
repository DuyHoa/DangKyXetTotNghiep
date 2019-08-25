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
		    <option value="k25">k25</option>
		    <option value="k26">k26</option>
		    <option value="k27">k27</option>
		    <option value="k28">k28</option>
		    <option value="k29">k29</option>
		    <option value="k30">k30</option>
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
   <a class="btn btn-success" href="{{ URL('/chuongtrinhhoc') }}"> Quay lại</a>
   <a class="delspace btn btn-danger">Xóa trắng</a>
   <button type="submit" class="btn btn-primary">Xác nhận</button>
</form>
</div>
<script type="text/javascript">
$(document).ready(function(){

	fetch_mh1_data();
	fetch_mh2_data();
	queryAll(a);
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
	 				}, 10000);
	 				console.log(message);
	 			},
	 			error:function(message){
	 				alert(message);
	 			}
 			});	
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
 	function queryAll(callback){
	 	$(document).on('keyup', '#searchdc', function(){
	  		var query1 = $(this).val();
	  		fetch_mh1_data(query1);
	 	});
	 	$(document).on('keyup', '#searchcn', function(){
	  		var query2 = $(this).val();
	  		fetch_mh2_data(query2);
	 	});
	 	setTimeout(function(){ callback(); }, 3000);
	 }

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
	function querryCN(){
	 	$(document).on('keyup', '#searchcn', function(){
	  		var query2 = $(this).val();
	  		fetch_mh2_data(query2);
	  		
	 	});
	 	setTimeout(function(){ a(); }, 3000);
	 }
});
</script>
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function(){



	setInterval(function(){
  		fetch_mh2ct_data();
  		fetch_mh1ct_data();
 	}, 500);

 	


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
 	}

 	$(document).on('keyup', '#searchdcct', function(){
  		var query1 = $(this).val();
  		fetch_mh1ct_data(query1);
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
 	}

 	$(document).on('keyup', '#searchcnct', function(){
  		var query2 = $(this).val();
  		fetch_mh2ct_data(query2);
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