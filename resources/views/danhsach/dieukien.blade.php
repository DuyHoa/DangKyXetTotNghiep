@extends('home')

@section('sub-title')
<div class="sub-title">
	<a>Cài đặt điều kiện xét tốt nghiệp</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
	<a>Quản lý điều kiện</a>
</div>
@endsection

@section('content')
<div class="col-sm-6 col-sm-push-3 m-a">
	@if($message = Session::get('success'))
    <div class ="alert alert-success">
        <p>{{$message}}</p>
    </div>
    @endif
    @if (!empty($success))
    <div class ="alert alert-success">
    	<p>{{$message}}</p>
    </div>
	@endif
	@if($message = Session::get('info'))
    <div class ="alert alert-info">
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

 <form action="{{ URL('/dieukien') }}" method="POST">
 	{{ csrf_field()}}
	<div class="form-group dfex">
		<label for="MaKhoa" class="col-md-4 row ">Chọn Khoa: </label>
		<select name="MaKhoa" id="MaKhoa" class="form-control input-lg">
			@foreach(App\khoa::all() as $value)
	    		<option value="{{ $value->MaKhoa}}">{{ $value->TenKhoa }}</option>
	     	@endforeach
		</select>
	</div>
	<div class="form-group dfex">
		<label for="MaNganh" class="col-md-4 row ">Chọn Ngành: </label>
		<select name="MaNganh" id="MaNganh" class="form-control input-lg">

		</select>
	</div>
	<div class="form-group dfex">
	    <label for="courseCode" class="row col-md-4">Chọn khóa:</label>
	    <select name="courseCode" id="courseCode" class="form-control input-lg dynamic">
	        <option value="">Chọn khóa</option>
	            @foreach(App\course::all() as $key)
	            <option value="{{ $key->course_code}}">{{ $key ->course_code }}</option>
	            @endforeach
	    </select>
	</div>
	<div class="form-group dfex">
		<label for="TongTC" class="col-md-4 row">Tín tự do: </label>
		<input type="text" name="TinTD" id="TinTD" class="form-control col-md-8" placeholder="...">
	</div>
	<div class="form-group dfex">
		<label for="TongTC" class="col-md-4 row">Tín tự chọn chuyên ngành: </label>
		<input type="text" name="TinTC" id="TinTC" class="form-control col-md-8" placeholder="...">
	</div>
	<div class="form-group dfex">
		<label for="DiemTB" class="col-md-4 row">Điểm Trung Bình: </label>
		<input type="text" name="DiemTB" id="DiemTB" class="form-control col-md-8" placeholder="...">
	</div>

	<button type="submit" class="btn btn-primary right">Tạo</button>
</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#MaNganh").change(function(){
			$("#DiemTB").removeAttr("value");
			$("#TinTC").removeAttr("value");
			$("#TinTD").removeAttr("value");
		});
		$("#courseCode").change(function(){
			$("#DiemTB").removeAttr("value");
			$("#TinTC").removeAttr("value");
			$("#TinTD").removeAttr("value");
			var val = $('#MaNganh option:selected').attr("value");
			var course = $('#courseCode option:selected').attr("value");
			var url = "/dieukien/"+val+"/"+course;
			$.get(url,function(data){
				$.each(data, function(i, value){
					$("#DiemTB").attr("value", value.DiemTB);
					$("#TinTD").attr("value", value.TinTD);
					$("#TinTC").attr("value", value.TinTC);
				
				})
			})
		})

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
	})
</script>
@endsection