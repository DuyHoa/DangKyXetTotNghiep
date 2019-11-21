@extends('home')

@section('content')
<div class="dotxet-1">
	{{ csrf_field()}}
	<div class="form-select">
		<label class="col-sm-2 row col-form-label">Chọn đợt:</label>
		<select class="form-control madot">
			@foreach(App\dotxet::all() as $value)
			<option value="{{ $value->MaDX }}">
				{{ $value->MaDX }}
				@if ($value->Status == 1)
					(đang mở)
				@else
					(chưa mở)
				@endif
			</option>
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
            <th>Xếp Loại</th>
            <th>Phát bằng</th>
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
			var url = "/list/chinhthuc/"+val;
			$.get(url,function(data){
				$.each(data, function(i, value){
					var content = "Chưa trao bằng";
					if(value.TrangThai != 0){
						content = "Đã trao bằng";
					}
					var tr = $("<tr/>");
					tr.append($("<td/>",{ text: value.id }))
					.append($("<td/>",{ text: value.MaSV }))
					.append($("<td/>",{ text: value.TenSV }))
					.append($("<td/>",{ text: value.MaNganh }))
					.append($("<td/>",{ text: value.Lop }))
					.append($("<td/>",{ text: value.Rank }))
					.append($("<td/>",{ text: content }));

					$('tbody.addListStudent').append(tr);
				});
				
			})
		})
	})
	</script>
@endsection