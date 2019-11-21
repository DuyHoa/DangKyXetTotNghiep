@extends('home')

@section('sub-title')
<div class="sub-title">
    <a>Quản lý ngành học</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
	<a>Quản lý Ngành học</a>
</div>
@endsection

@section('content')
	@if($message = Session::get('success'))
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
<div><a class="add btn btn-success" href="{{URL('/nganh/create')}}">Thêm mới</a></div>
<div class="form-group form-bangdiem form-getnganh">
	<p>Chọn Khoa</p>
    <select name="khoanganh" id="khoanganh" class="form-control input-lg dynamic" data-dependent="state">
    	<option value="%%">Tất cả</option>
    		@foreach(App\khoa::all() as $value)
    			<option value="{{ $value->MaKhoa}}">{{ $value->TenKhoa }}</option>
     		@endforeach
    </select>
</div>
<div class="nganh-1">
	<table class="bangdiem-l">
	<tr>
	      <th>Mã Ngành</td>      
	      <th>Tên Ngành</td>
	      <th>Thuộc Khoa</td>
	      <th class="action">Hành động</td>
	</tr>
	@foreach($gnganh as $key => $gnganh)
	    <tr>
	      <td>{{$gnganh->MaNganh}}</td>      
	      <td>{{$gnganh->TenNganh}}</td>
	  	  <td>{{$gnganh->TenKhoa}}</td>
	      <td class="action">
	      	<a href="{{URL('/nganh/edit', $gnganh->MaNganh)}}" class="khoa-edit btn btn-info" id="{{$gnganh->MaNganh}}">Sửa</a>
	      	<form method ="POST" action="{{ URL('nganh/delete') }}" onSubmit="if(!confirm('Bạn thực sự muốn xóa Ngành: {{ $gnganh->TenNganh }}?')){return false;}">
	      		{{ csrf_field() }}
	      		<input type="hidden" name="MaNganh" value="{{ $gnganh->MaNganh }}">
	      		<input type="submit" name="Delete"  value="Xóa" class="khoa-remove btn btn-warning">
	      	</form>	
	      </td>
	    </tr>
	@endforeach
	</table>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var csrfVar = $('meta[name="csrf-token"]').attr('content');
	$('#khoanganh').change(function() {
		var val = $("#khoanganh option:selected").val();
		var url = val;
		$(".bangdiem-l").empty();
		var temptr = $("<tr/>");
	    	temptr.append($("<th/>",{ text: "Mã ngành"
	    	})).append($("<th/>",{ text: "Tên ngành"
	    	})).append($("<th/>",{ text: "Thuộc Khoa"
	    	})).append($("<th/>",{ text: "Hành động"
	    	}));
		$(".bangdiem-l").append(temptr);
	    $.get(url,function(data){
	    	$.each(data, function(i, value){
	    		var tempurl = "/nganh/edit/"+ value.MaNganh;
	    		var tr = $("<tr/>");
	    			tr.append($("<td/>",{ text: value.MaNganh
	    			})).append($("<td/>",{ text: value.TenNganh
	    			})).append($("<td/>",{ text: value.TenKhoa
	    			})).append($("<td class='action' />")
	    			.append($("<a class='khoa-edit btn btn-info'/>").attr("href", tempurl).html("Sửa"))
	    			.append($("<form method ='POST' action='/nganh/delete' onSubmit=\"if(!confirm(\'Bạn thực sự muốn xóa Ngành: "+value.TenNganh+"?')){return false;}\"/>")
	    				.append($("<input type='hidden' name='_token' value='"+csrfVar+"'>"))
	    				.append($("<input type='hidden' name='MaNganh'>").val(value.MaNganh))
	    				.append($("<input type='submit' name='Delete'  value='Xóa' class='khoa-remove btn btn-warning'>"))));
	    		$(".bangdiem-l").append(tr);
	    	});
	    });
	});
})
</script>
@endsection