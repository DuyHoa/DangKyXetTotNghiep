@extends('home')

@section('sub-title')
<div class="sub-title">
    <a>Cập nhật môn thay thế</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
	<a>Quản lý môn học thay thế</a>
</div>
@endsection


@section('content')
<div class="col-sm-12">
	<div class="col-sm-5 col-sm-push-3 m-a" style="margin-bottom: 20px;">
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
	    @if(count($errors) > 0)
	    <div class ="alert alert-danger">
	        @foreach($errors->all() as $error)
	            <li>{{$error}}</li>
	        @endforeach
	    </div>
	    @endif

	    @foreach ($ob as $ob)
		<form action="{{ URL('/mh/thaythe/update') }}" method="POST" style="text-align: right;">
			{{ csrf_field() }}
			<div class="form-group dfex hidden">
				<label for="id" class="col-sm-7 row col-form-label">id:</label>
				<input type="text" name="id" id="id" class="form-control" value="{{ $ob->id }}"/>
			</div>
			<div class="form-group dfex">
				<label for="MaMH" class="col-sm-7 row col-form-label">Mã môn:</label>
				<input type="text" name="MaMH" id="MaMH" placeholder="Nhập..." class="form-control" value="{{ $ob->MaMH }}"/>
			</div>
			<div class="form-group dfex">
				<label for="MaMTT" class="col-sm-7 row col-form-label">Mã môn thay thế:</label>
				<input type="text" name="MaMTT" id="MaMTT" placeholder="Nhập..." class="form-control" value="{{ $ob->MaMTT }}"/>
			</div>
			<button class="btn btn-success">Xác nhận</button>
		</form>
		@endforeach
	</div>
</div>
  <div class="dotxet-1">
  	<table class="bangdiem-l">
  		<tr>
  			<th>STT</th>
  			<th>Môn</th>
  			<th>Môn thay thế</th>
  			<th>Hành động</th>
  		</tr>
  		<tbody class="addListMH">
  			
  		</tbody>
  	</table>
  </div>
<script type="text/javascript">
	$(document).ready(function(){
		url = "/mh/tt";
		$.get(url, function(data){
			$.each(data, function(i, value){
				var tempurl = "/mh/tt/edit/"+value.id;
				var csrfVar = $('input[name="_token"]').val();
				var tr = $("<tr/>");
					tr.append($("<td/>",{ text: value.id }))
					.append($("<td/>",{ text: value.TenMon+" ("+value.MaMH+")" }))
					.append($("<td/>",{ text: value.MaMTT }))
					.append($("<td class='action' />")
	    			.append($("<a class='khoa-edit btn btn-info'/>").attr("href", tempurl).html("Sửa"))
	    			.append($("<form method ='POST' action='/mh/thaythe/delete' onSubmit=\"if(!confirm(\'Bạn thực sự muốn xóa môn học: "+value.TenMon+"?')){return false;}\" />")
	    				.append($("<input type='hidden' name='_token' value='"+csrfVar+"'>"))
	    				.append($("<input type='hidden' name='id'>").val(value.id))
	    				.append($("<input type='submit' name='Delete'  value='Xóa' class='khoa-remove btn btn-warning'>"))));
					$('tbody.addListMH').append(tr);
			});
		})
	})
</script>
@endsection