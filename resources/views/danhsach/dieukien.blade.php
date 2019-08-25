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
		<label for="MaDot" class="col-md-4 row ">Chọn Đợt xét: </label>
		<select name="MaDot" id="MaDot" class="form-control input-lg">
			@foreach(App\dotxet::all() as $value)
	    		<option value="{{ $value->MaDX}}">{{ $value->TenDX }} ( {{ $value->NgayBatDau }}-{{ $value->NgayKetThuc }} )</option>
	     	@endforeach
		</select>
	</div>
	<div class="form-group dfex">
		<label for="TongTC" class="col-md-4 row">Tổng tín chỉ: </label>
		<input type="text" name="TongTC" id="TongTC" class="form-control col-md-8" placeholder="...">
	</div>
	<div class="form-group dfex">
		<label for="DiemTB" class="col-md-4 row">Điểm Trung Bình: </label>
		<input type="text" name="DiemTB" id="DiemTB" class="form-control col-md-8" placeholder="...">
	</div>

	<button type="submit" class="btn btn-primary">Tạo</button>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$("#MaNganh").change(function(){
			$("#DiemTB").removeAttr("value");
			$("#TongTC").removeAttr("value");
		});
		$("#MaDot").change(function(){
			$("#DiemTB").removeAttr("value");
			$("#TongTC").removeAttr("value");
			var val = $('#MaNganh option:selected').attr("value");
			var dot = $('#MaDot option:selected').attr("value");
			var url = "/dieukien/"+val+"/"+dot;
			$.get(url,function(data){
				$.each(data, function(i, value){
					$("#DiemTB").attr("value", value.DiemTB);
					$("#TongTC").attr("value", value.TongTC);
				
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