@extends('home')

@section('sub-title')
<div class="sub-title">
    <a>Cập nhật ngôn ngữ 2</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
	<a>Quản lý Ngoại ngữ 2</a>
</div>
@endsection

@section('content')
<div class="col-sm-12">
	<div class="col-sm-6 col-sm-push-3 m-a">
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

		<form action="{{ URL('/mh/nn2/update') }}" method="POST" style="text-align: right;">
			{{ csrf_field() }}
			<div class="form-group dfex">
				<label for="MaMon" class="col-sm-6 row col-form-label">Mã môn:</label>
				<input type="text" name="MaMon" id="MaMon" placeholder="Nhập..." class="form-control" value="{{ $fnn->MaMon }}"/>
			</div>
			<div class="form-group dfex">
				<label for="TenMon" class="col-sm-6 row col-form-label">Tên môn:</label>
				<input type="text" name="TenMon" id="TenMon" placeholder="Nhập..." class="form-control" value="{{ $fnn->TenMon }}"/>
			</div>
			<div class="form-group dfex">
				<label for="Loai"class="col-sm-6 row col-form-label" >Loại:</label>
				<select name="Loai" id="Loai" class="form-control">
					<option value="{{ $fnn->Loai }}">
						@if($fnn->Loai == 'NN1')
							Ngôn ngữ 1
						@else
							Ngôn ngữ 2
						@endif
					</option>
					@if($fnn->Loai == 'NN1')
						<option value="NN2">Ngôn ngữ 2</option>
					@else
						<option value="NN1">Ngôn ngữ 1</option>
					@endif
				</select>
			</div>
			<button class="btn btn-success">Xác nhận</button>
		</form>
	</div>
</div>
<div class="dotxet-1">
  	<table class="bangdiem-l">
  		<tr>
  			<th>STT</th>
  			<th>Mã Môn</th>
  			<th>Tên Môn</th>
  			<th>Thuộc nhóm</th>
  			<th>Hành động</th>
  		</tr>
  		<tbody class="addListMH">
  			
  		</tbody>
  	</table>
  </div>

<script type="text/javascript">
	$(document).ready(function(){
		url = "/mhjson/nn2";
		var csrfVar = $('input[name="_token"]').val();
		$.get(url, function(data){
			$.each(data, function(i, value){
				var tempurl = "/mh/nn2/edit/"+value.MaMon;

				var tr = $("<tr/>");
					tr.append($("<td/>",{ text: value.id }))
					.append($("<td/>",{ text: value.MaMon }))
					.append($("<td/>",{ text: value.TenMon }))
					.append($("<td/>",{ text: value.Loai }))
					.append($("<td class='action' />")
	    			.append($("<a class='khoa-edit btn btn-info'/>").attr("href", tempurl).html("Sửa"))
	    			.append($("<form method ='POST' action='/mh/nn2/delete' onSubmit=\"if(!confirm(\'Bạn thực sự muốn xóa môn học: "+value.TenMon+"?')){return false;}\"/>")
	    				.append($("<input type='hidden' name='_token' value='"+csrfVar+"'>"))
	    				.append($("<input type='hidden' name='MaMon'>").val(value.MaMon))
	    				.append($("<input type='submit' name='Delete'  value='Xóa' class='khoa-remove btn btn-warning'>"))));
					$('tbody.addListMH').append(tr);
			});
		})
	})
</script>
@endsection