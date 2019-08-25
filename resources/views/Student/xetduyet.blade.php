@extends('home')


@section('sub-title')
<div class="sub-title">
	<a>Xét tốt nghiệp thủ công</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
  <a>Quản lý xét duyệt</a>
</div>
@endsection


@section('content')
{{ csrf_field() }}
<h3 style="display: flex;">Xét duyệt cho sinh viên <p style="color: #2352a6; padding-left: 7px;" class="msv"></p></h3>
<div class="dotxet-1">
	<table class="bangdiem-l">
	<tr> 
	    <th>Mã Môn</th>
	    <th>Tên môn</th>
	    <th>Tín chỉ</th>
	    <th>Thuộc</th>
	    <th>Điểm</th>
	    <th>Trang thái</th>
	</tr>
	@foreach($xetduyet as $value)
	<tr>
		<td>
		@if (isset($value->MaMTT))
			{{ $value->MaMTT }}
		@else
			{{ $value->MaMH }}
		@endif
		</td>
		<td>{{ $value->TenMH }}</td>
		<td>{{ $value->SoTC }}</td>
		<td>
			@if (isset($value->Term))
				@if ($value->Term == 0)
					đại cương
				@else
					chuyên ngành
				@endif
			@else
				@if (isset($value->MaMTT))
					thay thế {{ $value->MaMH }}
				@else
					ngôn ngữ 2
				@endif
			@endif
		</td>
		<td>{{ $value->Diem }}</td>
		<td>
			@if( $value->Diem >= 4.6)
				<p class="noimg mg-5 alert-success">Hoàn thành</p>
			@else
				<p class="noimg mg-5 alert-danger">Chưa đạt</p>
			@endif
		</td>
	</tr>
	@endforeach
	<tr>
		<td></td>
		<td>Tổng</td>
		<td>{{ $xetduyet->sum('SoTC') }}</td>
		<td></td>
		<td>{{ round($xetduyet->avg('Diem'), 2) }}</td>
		<td>
			@if( $xetduyet->avg('Diem') < 6 )
				<strong class="noimg alert-danger">Trung Bình</strong>
			@elseif( $xetduyet->avg('Diem') >= 6 && $xetduyet->avg('Diem') < 7)
				<strong class="noimg alert-warning">Trung Bình Khá</strong>
			@elseif( $xetduyet->avg('Diem') >= 7 && $xetduyet->avg('Diem') < 8)
				<strong class="noimg alert-info">Khá</strong>
			@elseif( $xetduyet->avg('Diem') >= 6 && $xetduyet->avg('Diem') < 7)
				<strong class="noimg alert-primary">Giỏi</strong>
			@else
				<strong class="noimg alert-success">Xuất Sắc</strong>
			@endif
		</td>
	</tr>
	</table>
</div>
<?php $i = 0; ?>
	@foreach($xetduyet as $key)
        @if($i < 1)
			<a name="2ndlist" id="{{ $key->SinhViens_MaSV }}" value="{{ $key->SinhViens_MaSV }}" class="btn btn-dark addList">Thêm danh sách dự kiến</a>
			<script type="text/javascript">
				var MaSV = $(".addList").attr("value");
				$(".msv").html(" "+MaSV);
			</script>
		@else

		@endif
		<?php $i++; ?>
	@endforeach
<a class="btn btn-primary goback">Quay lại</a>


<script type="text/javascript">
	$(document).ready(function(){
		var _token = $('input[name="_token"]').val();
		addListStudent();

		//go back
		$('.goback').on("click",function(){
			window.history.back();
		})

		//Thêm sinh viên vào danh sách dự kiến
		function addListStudent(){
			$(".addList").on("click", function(){
				var MaSV = $(this).attr("value");
				var flag = false;
				$.get("/xetduyet",function(data){
					$.each(data, function(i, value){
						//Kiểm tra sinh viên đã tồn tại trong danh sách chưa
						if(value.MaSV != MaSV){
							flag = false;
						}
						else
							flag = true;
					})
					//Nếu chưa có trong danh sách
					if(flag){
						alert("Sinh viên đã có trong danh sách dự kiến");
					}
					//Nếu đã có trong danh sách, cho phép post
					else{
						$.ajax({
							url: "/xetduyet",
							method: "POST",
							data: {
								MaSV: MaSV,
								_token: _token,
							},
							success:function(data){
								console.log("Đã thêm sinh viên "+ MaSV +" thành công.");
							},
							error:function(xhr, status, error) {
			                    console.log(xhr.responseText);
			                },
						});
						alert("Đã thêm sinh viên "+ MaSV +" thành công.");
					}
				})	
			});
		}
	})
</script>
@endsection