@extends('home')

@section('sub-title')
<div class="sub-title">
    <a>Danh sách môn học</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
    <a>Quản lý Môn Học</a>
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


<div class="panel">
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">Search</span>
    	<input type="text" name="search" id="search" class="form-control" placeholder="Tìm kiếm dữ môn học" />
      <div class="add"><a class="btn btn-success" href="{{URL('/monhoc/create')}}">Thêm mới</a></div>
  	</div>
  </div>
  <div class="table-responsive ">
    <h4 align="left">Số môn học: <span id="total_records"></span></h4>
      <table class="bangdiem-l" id="dtVerticalScrollExample">
       <thead>
        <tr>
         <th>Mã Môn</th>
         <th>Tên Môn</th>
         <th>Tín chỉ</th>
         <th>Hành động</th>
        </tr>
       </thead>
       <tbody>
                
       </tbody>
      </table>
    </div>
 </div>
@endsection


@section('script')
<script>
$(document).ready(function(){
 	fetch_customer_data();
 	function fetch_customer_data(query = '')
 	{
  		$.ajax({
	   		url:"{{ route('monhoc.action') }}",
	   		method:'GET',
	   		data:{query:query},
	   		dataType:'json',
	   		success:function(data)
	   		{
	    		$('tbody').html(data.table_data);
	    		$('#total_records').text(data.total_data);
	   		}
  		})
 	}

 	$(document).on('keyup', '#search', function(){
  		var query = $(this).val();
  		fetch_customer_data(query);
 	});
  $('#dtVerticalScrollExample').DataTable({
    "scrollY": "600px",
    "scrollCollapse": true,
  });
  
});
</script>
@endsection