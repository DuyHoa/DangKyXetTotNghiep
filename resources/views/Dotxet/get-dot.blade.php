@extends('home')

@section('sub-title')
<div class="sub-title">
  <a>Danh sách đợt xét</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
  <a>Quản lý đợt xét</a>
</div>
@endsection

@section('content')
@if($message = Session::get('success'))
    <div class ="alert alert-success">
        <p>{{$message}}</p>
    </div>
@endif
@if($message = Session::get('info'))
    <div class ="alert alert-info">
        <p>{{$message}}</p>
    </div>
@endif
@if($message = Session::get('remove'))
    <div class ="alert alert-warning">
        <p>{{$message}}</p>
    </div>
@endif
@if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors ->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<select class="browser-default custom-select select-year-action" id="select-year-action">
	<option>Chọn năm</option>
@foreach($dotxet as $key => $dotxet)
	<option value="{{ $dotxet->formatted_NgayBatDau }}" name="{{ $dotxet->formatted_NgayBatDau }}">{{ $dotxet->formatted_NgayBatDau }}</option>
@endforeach
</select>
<div class="add" style="padding-bottom: 10px;"><a class="btn btn-success" href="{{URL('/dotxet/create')}}">Thêm mới</a></div>
<div class="dotxet-1">
	<table class="bangdiem-l">
		<thead>
			<tr> 
				<th>STT</th>
			    <th>Tên đợt xét</th>
			    <th>Trạng thái</th>
			    <th>Ngày bắt đầu</th>
			    <th>Ngày kết thúc</th>
			    <th>Hành động</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
@endsection
@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			var _token = $('input[name="_token"]').val();
			$("#select-year-action").change(function(){
				if($(this).val() != ''){
					var formatted_NgayBatDau = $(this).val();
					$.ajax({
						url: "/dotxet/fillName",
						method: "POST",
						data: {
							formatted_NgayBatDau: formatted_NgayBatDau,
							_token: _token,
						},
						success:function(result){
							$("tbody").html(result);
						},
						error:function(mes){
		                    console.log(mes);
		                },
					})
				}
				setTimeout(function(){ RemoveDot(); }, 1000);
			});

			function RemoveDot(){
				$('.dot-remove').each(function(){
					var MaDX = $(this).attr("id");
					$(this).on("click", function(){
						$.ajax({
							url: "/dotxet/delete",
							method: "POST",
							data: {
								MaDX: MaDX,
								_token: _token,
							},
							success:function(mes){
								location.reload();
							}
						})
					})

				})
			}
		})
	</script>
@endsection

