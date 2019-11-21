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
		<select class="form-control manam" id="namxet">
			@foreach($val as $value)
			<option value="{{ $value->formatted_NgayBatDau }}">
				{{ $value->formatted_NgayBatDau }}
			</option>
			@endforeach
		</select>
	</div>
	<div class="form-select">
		<label class="col-sm-2 row col-form-label">Chọn đợt:</label>
		<select class="form-control madot" id="madot">
			<option>-----</option>
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
            <th>Tín tự do</th>
            <th>Hành động</th>
        </tr>
        <tbody class="addListStudent">

        </tbody>
   	</table>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		
	})
	</script>
	<style>
		.ds-1 td{
			padding: 10px 3px;
		}
	</style>
@endsection
@section('script')
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
					var action_4 = "KHÔNG ĐẠT";
					if(value.Diem != 0)
						action_1 = "ĐẠT";
					if(value.Tinchi != 0)
						action_2 = "ĐẠT";
					if(value.NN != 0)
						action_3 = "ĐẠT"
					if(value.Tudo != 0)
						action_4 = "ĐẠT"
					var tr = $("<tr/>");
					tr.append($("<td/>",{ text: i+1 }))
					.append($("<td/>",{ text: value.MaSV }))
					.append($("<td/>",{ text: value.TenSV, class: "name-left"}))
					.append($("<td/>",{ text: value.TenNganh }))
					.append($("<td/>",{ text: value.Lop }))
					.append($("<td/>",{ text: action_1 }))
					.append($("<td/>",{ text: action_2 }))
					.append($("<td/>",{ text: action_3 }))
					.append($("<td/>",{ text: action_4 }))
					.append($("<td/>").append($("<a/>", { text: "Chi tiết", class: "btn btn-info showInfo", studentcode: value.MaSV, })));
					$('tbody.addListStudent').append(tr);
				});	
			})
			setTimeout(function(){showInfo(); closeInfo();}, 1000);
		})


		function showInfo(){
			$('.showInfo').each(function(){
				$(this).on('click', function(){
					var maSV = $(this).attr('studentcode');
					var _token = $('input[name="_token"]').val();
					$.ajax({
						url:"/huyinfo",
				   		method:'POST',
				   		data: {maSV: maSV, _token: _token},
				   		success:function(data){
				   			$("#popup-list").css('display', 'block');
				   			$('.popup-list-main').html(data);
				   		},
				   		error: function(xhr, status, error) {
						  var err = JSON.parse(xhr.responseText);
						  console.log(err);
						}
					})
				})
			})
			closeInfo();
		}
		function closeInfo(){
			$('.popup-list-head').on('click', function(){
				if($("#popup-list").is(":visible")){
					$("#popup-list").fadeOut();
					/*$("#popup-list").css('display', 'none');*/
				}
			})
		}
	})
</script>


@endsection