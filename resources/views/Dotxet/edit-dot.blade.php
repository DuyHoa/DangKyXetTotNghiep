@extends('home')

@section('content')
<div class="col-sm-6 col-sm-push-3 m-a">
@if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors ->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

 <form action="{{ url('dotxet/update') }}" method="POST" role="form">
        <legend>Tạo đợt xét</legend>
        {{ csrf_field()}}
        <div class="form-group">
            <label for="">Mã Đợt</label>
            <input type="text" name="MaDX" class="form-control" id="" placeholder="Input field" value="{{ $dotxet->MaDX }}">
        </div>
        <div class="form-group">
            <label for="">Tên Đợt</label>
            <input type="text" name="TenDX" class="form-control" id="" placeholder="Input field" value="{{ $dotxet->TenDX }}">
        </div>
        <div class="form-group">
        <label for="">Trạng thái</label>
		    <select name="Status" id="status-dx" class="form-control input-lg dynamic" data-dependent="state">
                <option value="{{ $dotxet->Status }}">
                	@if($dotxet->Status == '1')
						<p>Hoạt động</p>
				  	@elseif($dotxet->Status == '0')
				  		<p>Hết hạn</p>
				  	@endif
                </option>
		    	@if ($dotxet->Status == '1')
		    		<option value="0">Hết hạn</option>
		    	@else
		    		<option value="1">Hoạt động</option>
		    	@endif
		    </select>
        </div>
        <div class="form-group">
            <label for="">Ngày bắt đầu</label>
            <input type="date" name="NgayBatDau" class="form-control" id="" placeholder="Input field" value="{{ $dotxet->NgayBatDau }}">
        </div>
        <div class="form-group">
            <label for="">Ngày kết thúc</label>
            <input type="date" name="NgayKetThuc" class="form-control" id="" placeholder="Input field" value="{{ $dotxet->NgayKetThuc }}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection