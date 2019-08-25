@extends('home')

@section('sub-title')
<div class="sub-title">
  <a>Danh sách sinh viên có bảng điểm</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
  <a>Quản lý Sinh viên</a>
</div>
@endsection


@section('content')
@if($message = Session::get('success'))
    <div class ="alert alert-success">
        <p>{{$message}}</p>
    </div>
@endif
@if($message = Session::get('remove'))
    <div class ="alert alert-warning">
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
<div class="add" style="padding-bottom: 15px"><a class="btn btn-success" href="{{URL('/bangdiem/importexcel')}}">Thêm mới</a></div>

<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<div class="formflex">
	<div class="form-group">
	    <select name="Khoa" id="MaKhoa" class="form-control input-lg dynamic" data-dependent="MaNganh">
	        <option value="">Chọn Khoa</option>
	            @foreach(App\Khoa::all() as $key)
	        <option value="{{ $key->MaKhoa}}">{{ $key ->TenKhoa }}</option>
	            @endforeach
	        </select>
	    </div>
	<div class="form-group">
	    <select name="Nganh" id="MaNganh" class="form-control input-lg dynamic">
	        <option value="">Chọn ngành</option>
	    </select>
	</div>
	<div class="form-group">
		<div class="input-group">
			<input type="text" name="MaSV" id="MaSV" class="form-control" placeholder="Nhập mã sinh viên">
		</div>
	</div>
</div>
<div>
	<table class="bangdiem-l">
       <thead>
        <tr>
         <th>Mã SV</th>
         <th>Tên SV</th>
         <th>Tên Khoa</th>
         <th>Tên Nganh</th>
         <th>Khoa</th>
         <th>Bảng điểm</th>
        </tr>
       </thead>
       <tbody>

       </tbody>
      </table>
</div>




<script type="text/javascript">
$(document).ready(function(){
	

    $("#MaKhoa").change(function(){
        if($(this).val != ''){
            var select = $(this).attr("id"); //Makhoa--MaNganh
            var value = $(this).val(); //Makhoa--
            var dependent = $(this).data('dependent'); //MaNganh
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('NganhKhoadependent.fetch') }}",
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
                error:function(xhr, status, error) {
  					console.log(xhr.responseText);
                }
            });
        }
    });


    fetch_sinhvien_data();

    function fetch_sinhvien_data(MaSV = '')
 	{
 		var MaKhoa = $("#MaKhoa option:selected").val();
 		var MaNganh = $("#MaNganh option:selected").val();
  		$.ajax({
	   		url:"{{ route('sinhvien.action') }}",
	   		method:'GET',
	   		data:{
	   			MaKhoa: MaKhoa,
	   			MaNganh: MaNganh, 
	   			MaSV: MaSV
	   		},
	   		dataType:'json',
	   		success:function(data)
	   		{
	    		$('tbody').html(data.table_data);
	    		console.log(data);
	   		},
	   		error:function(xhr, status, error) {
  				var err = JSON.parse(xhr.responseText);
  				console.log(err);
            },
  		});
 	}

 	$(document).on('keyup', '#MaSV', function(){
  		var MaSV = $(this).val();
  		fetch_sinhvien_data(MaSV);
 	});
});
</script>
@endsection