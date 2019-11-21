@extends('home')

@section('sub-title')
<div class="sub-title">
	<a>Danh sách dự kiến và xét duyệt tự động</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
	<a>Danh sách dự kiến</a>
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
		<label class="col-sm-2 row col-form-label">Chọn năm:</label>
		<select class="form-control namxet" id="namxet">
			@foreach($list as $key)
			<option>{{ $key->formatted_NgayBatDau }}</option>
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
	function runNull(){
		$(".null").on("click", function(){
	      if($("#popup").is(":hidden")){
	        $("#popup").css("display","block");
	      }
	    })
	    $(".popup-button-close").on("click",function(){
	      if($("#popup").is(":visible")){
	        $("#popup").fadeOut();
	      }
	    })
	};
	setTimeout(function(){ runNull() }, 1000);
	function xetduyet_popup(){
		$(".xd1").each(function(){
			$(this).on("click", function(){
				var MSV = $(this).attr("value");
				$("#popup-alert").css("display", "block");
				$(".popup-alert-head").empty();
				$(".popup-alert-main").empty();
				$(".popup-alert-head").append($("<p/>",{text: "Chọn khóa", class: "popup-null-head-content",}));
				$(".popup-alert-main").append($("<p/>",{text: "Chọn khóa xét duyệt cho sinh viên "+MSV+": "})).append($("<select/>", {name: "khoas", class: "khoa-select"}))
				$.get("/get/course", function(data){
					$.each(data, function(i, value){
						$(".khoa-select").append($("<option/>", {value: value.course_code, text: value.course_code}));
					})
				});
				$(".popup-alert-main").append($("<a/>",{text: "xét duyệt", class: "popup-null-main-button goto xd",id: "xd", value: MSV})).append($("<a/>",{text: "Hủy", class: "cancle-xd popup-null-main-button", id: "cancle-xd"}));
				$("#cancle-xd").on("click", function(){ $("#popup-alert").fadeOut("fast"); })
				$("#xd").on("click", function(){
					$(".alert-custome").fadeOut("fast");
					$(".alert-custome").html(" ");
					$(".alert-custome").fadeIn("slow");
					var maSV = $(this).attr("value");
					var khoas = $(".khoa-select option:selected").val();
					$(this).html(">Loading");
					$.ajax({
						url: "/xetduyet/action",
						method: "POST",
						data: {
							maSV: maSV,
							khoas: khoas,
							_token: _token,
						},
						success:function(message){
							//alert(message.message);
							$(".alert-custome").html(message.message);
							$("#popup-alert").fadeOut("fast");
							setTimeout(function(){ $(".alert-custome").fadeOut("fast"); }, 3000);
							
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
		})
	}
	$(document).ready(function(){
		var _token = $('input[name="_token"]').val();
		
		$(".madot").change(function(){
			$("tbody.addListStudent").empty();
			var val = $(".madot option:selected").val();
			var url = "/list/dukien/"+val;
			$.get(url,function(data){
				$.each(data, function(i, value){
					var content = "Chưa xét duyệt";
					var action = "Xét duyệt";
					var temp = "Không Đạt";
					var count = 1;
					var id = value.id;
					if(value.TinhTrang != 0){
						content = "Đã xét duyệt";
						action = "Đã xét duyệt";
					}
					if(value.isDat != 0){
						temp = "Đạt";
					}
					var tr = $("<tr/>", { class: id});
					tr.append($("<td/>",{ text: i+1}))
					.append($("<td/>",{ text: value.MaSV}))
					.append($("<td/>",{ text: value.TenSV, class: "name-left"}))
					.append($("<td/>",{ text: value.MaNganh}))
					.append($("<td/>",{ text: value.Lop}))
					.append($("<td/>",{ text: content, class: status, }))
					.append($("<td/>",{ text: temp, }))
					.append($("<td/>").append($("<a/>", { text: action, class: "btn btn-dark mg-5 xd1", value: value.MaSV, name: value.MaSV,})).append($("<a/>", { text: "Xóa", class: "btn btn-dark mg-5 del null", value: value.MaSV, name: value.MaSV,})));
					$('tbody.addListStudent').append(tr);
				});
			})
			setTimeout(function() {duyetlist()}, 1000);
			setTimeout(function(){ runNull(); xetduyet_popup() }, 1000);

		})
		//setTimeout(function() {duyetlist()}, 3000);
		function duyetlist(){
			$(".xd").each(function(){
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