@extends('home')

@section('sub-title')
<div class="sub-title">
	<a>Danh sách sinh viên đủ điều kiện và quản lý trao bằng</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
	<a>Danh sách chính thức</a>
</div>
@endsection


@section('content')
<div class="dotxet-1">
	{{ csrf_field()}}
	<div class="form-select">
		<label class="col-sm-2 row col-form-label">Chọn đợt:</label>
		<select class="form-control manam" id="namxet">
			@foreach($listct as $value)
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
            <th>Xếp Loại</th>
            <th>Phát bằng</th>
        </tr>
        <tbody class="addListStudent">

        </tbody>
   	</table>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var _token = $('input[name="_token"]').val();
		$(".madot").change(function(){
			$("tbody.addListStudent").empty();
			var val = $(".madot option:selected").val();
			var url = "/list/chinhthuc/"+val;
			$.get(url,function(data){
				$.each(data, function(i, value){
					var content = "Chưa trao bằng";
					if(value.TrangThai != 0){
						content = "Đã trao bằng";
					}
					var tr = $("<tr/>");
					tr.append($("<td/>",{ text: i+1 }))
					.append($("<td/>",{ text: value.MaSV }))
					.append($("<td/>",{ text: value.TenSV, class: "name-left" }))
					.append($("<td/>",{ text: value.MaNganh }))
					.append($("<td/>",{ text: value.Lop }))
					.append($("<td/>",{ text: value.Rank }));
					if(value.TrangThai != 0){
						tr.append($("<td/>", { class: 'action' }).append($("<input/>", { type: "checkbox", MaSV: value.MaSV, checked: "checked", name: "MaSV", class: "checkbox", disabled: "disabled" })).append($("<p/>", { text: content, id: value.MaSV })));
					}
					else{
						tr.append($("<td/>", { class: 'action' }).append($("<input/>", { type: "checkbox", MaSV: value.MaSV, name: "MaSV", class: "checkbox" })).append($("<p/>", { text: content, id: value.MaSV })));
					}

					$('tbody.addListStudent').append(tr);
				});
			})
			setTimeout(function(){ tickCheckBox(); }, 2000); 
		})
		function tickCheckBox(){
			$(".checkbox").each(function(){
				var MaSV = $(this).attr("MaSV");
				var id = "#"+MaSV
				if($(this).attr("disabled")){

				}
				else{
					$(this).on("click", function(){
						if(this.checked){
							$(this).attr("disabled", "disabled");
							$("#"+MaSV).html("Đã trao bằng");
							$.ajax({
								url: '/trao-bang',
								method: "POST",
								data: {
									MaSV: MaSV,
									_token: _token,
								},
								success:function(message){
									alert(message.message);
								},
								error:function(xhr, status, error) {
				                    console.log(xhr.responseText);
				                },
							});
						}
					})
				}
			})
		}

	})
	</script>
@endsection