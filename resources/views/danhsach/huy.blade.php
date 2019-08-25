@extends('home')

@section('sub-title')
<div class="sub-title">
	<a>Danh sách sinh viên không đủ điều kiện và lý do</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
	<a>Quản lý xét duyệt</a>
</div>
@endsection


@section('content')
<div class="ds-1">
	{{ csrf_field()}}
	<div class="form-select">
		<label class="col-sm-2 row col-form-label">Chọn đợt:</label>
		<select class="form-control madot">
			@foreach(App\dotxet::all() as $value)
			<option value="{{ $value->MaDX }}">{{ $value->MaDX }}</option>
			@endforeach
		</select>
	</div>
	<div class ="alert alert-success alert-custome"></div>
    <table class = "bangdiem-l">
        <tr>
            <th>STT</th>
            <th>Mã</th>
            <th>Họ tên</th>
            <th>Ngành</th>
            <th>Lớp</th>
            <th>Điểm</th>
            <th>Tín chỉ</th>
            <th>Ngôn ngữ 2</th>
        </tr>
        <tbody class="addListStudent">

        </tbody>
   	</table>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$(".madot").change(function(){
			$("tbody.addListStudent").empty();
			var val = $(".madot option:selected").val();
			var url = "/list/huy/"+val;
			$.get(url,function(data){
				$.each(data, function(i, value){
					var action_1 = "KHÔNG ĐẠT";
					var action_2 = "KHÔNG ĐẠT";
					var action_3 = "KHÔNG ĐẠT";
					if(value.Diem != 0){
						action_1 = "ĐẠT";
					}
					if(value.Tinchi != 0){
						action_2 = "ĐẠT";
					}
					if(value.NN != 0)
						action_3 = "Đạt"
					var tr = $("<tr/>");
					tr.append($("<td/>",{ text: value.id }))
					.append($("<td/>",{ text: value.MaSV }))
					.append($("<td/>",{ text: value.TenSV }))
					.append($("<td/>",{ text: value.TenNganh }))
					.append($("<td/>",{ text: value.Lop }))
					.append($("<td/>",{ text: action_1 }))
					.append($("<td/>",{ text: action_2 }))
					.append($("<td/>",{ text: action_3 }));
					$('tbody.addListStudent').append(tr);
				});
				
			})
		})
	})
	</script>
	<style>
		.ds-1 td{
			padding: 10px 3px;
		}
	</style>
@endsection