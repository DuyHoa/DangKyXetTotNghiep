@extends('home')

@section('sub-title')
<div class="sub-title">
	<a>Danh sách dự kiến và xét duyệt tự động</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
	<a>Quản lý xét duyệt tự động</a>
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
<div class="dotxet-1">
	{{ csrf_field()}}
	<div class="form-select">
		<label class="col-sm-2 row col-form-label">Chọn đợt:</label>
		<select class="form-control madot">
			@foreach($list as $key)
			<option>{{ $key->MaDX }}</option>
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
            <th>Trạng Thái</th>
            <th>Đạt</th>
            <th>Hành động</th>
        </tr>
        <tbody class="addListStudent">

        </tbody>
   	</table>
   	<a href="{{ URL('/list/chinhthuc') }}" class="btn btn-success">Đến danh sách chính thức</a>
   	<a href="{{ URL('/list/huy') }}" class="btn btn-warning">Đến danh sách sinh viên chưa đủ điều kiện</a>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		
	

		$(".madot").change(function(){
			$("tbody.addListStudent").empty();
			var val = $(".madot option:selected").val();
			var url = "/list/dukien/"+val;
			$.get(url,function(data){
				$.each(data, function(i, value){
					var content = "Chưa xét duyệt";
					var action = "Xét duyệt";
					var temp = "Không Đạt"
					if(value.TinhTrang != 0){
						content = "Đã xét duyệt";
						action = "Đã xét duyệt";
					}
					if(value.isDat != 0){
						temp = "Đạt";
					}
					var tr = $("<tr/>");
					tr.append($("<td/>",{ text: value.id}))
					.append($("<td/>",{ text: value.MaSV}))
					.append($("<td/>",{ text: value.TenSV}))
					.append($("<td/>",{ text: value.MaNganh}))
					.append($("<td/>",{ text: value.Lop}))
					.append($("<td/>",{ text: content, class: status, }))
					.append($("<td/>",{ text: temp, }))
					.append($("<a/>", { text: action, class: "btn btn-dark mg-5 xd", value: value.MaSV, name: value.MaSV,}));

					$('tbody.addListStudent').append(tr);
				});
				
			})
			setTimeout(function() {duyetlist()}, 1000);
		})
		//setTimeout(function() {duyetlist()}, 3000);
		function duyetlist(){
			$(".xd").each(function(){
				var _token = $('input[name="_token"]').val();
				$(this).on("click", function(){
					$(".alert-custome").fadeOut("fast");
					$(".alert-custome").html(" ");
					$(".alert-custome").fadeIn("slow");
					var maSV = $(this).attr("value");
					$(this).html("Đang xử lý");
					$.ajax({
						url: "/xetduyet/action",
						method: "POST",
						data: {
							maSV: maSV,
							_token: _token,
						},
						success:function(message){
							//alert(message.message);
							$(".alert-custome").html(message.message);
						},
						error:function(xhr, status, error) {
	                        console.log(xhr.responseText);
	                    },
					})
					var url = "/list/dukien/"+maSV;
					$.get(url,function(data){
						$.each(data, function(i, value){
							var str = ".xd[name="+maSV+"]";
							if(value.TinhTrang != 0){
								$(".status").html("Đang xét duyệt");
								$(str).attr("disabled", )
								$(str).html("Đã xét duyệt");
							}
						});
					})
					//alert('Sinh viên '+maSV+' Đã xử lý xét duyệt xong!') ? "" : location.reload();
				})
			})
		}
	})
</script>
@endsection