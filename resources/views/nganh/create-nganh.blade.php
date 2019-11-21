@extends('home')

@section('sub-title')
<div class="sub-title">
    <a>Tạo mới Ngành học</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
    <a>Quản lý Ngành học</a>
</div>
@endsection

@section('content')
<div class="col-sm-4 col-sm-push-4 m-a">
        @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors ->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
 <form action="{{ url('nganh') }}" method="POST" role="form">
        {{ csrf_field()}}
        <div class="form-group">
            <label for="">Mã Ngành học</label>
            <input type="text" name="MaNganh" class="form-control" id="" placeholder="Input field">
        </div>
        <div class="form-group">
            <label for="">Tên Ngành học</label>
            <input type="text" name="TenNganh" class="form-control" id="" placeholder="Input field">
        </div>
        <div class="form-group">
            <label for="">Thuộc Khoa</label>
		    <select name="Khoas_MaKhoa" id="khoa" class="form-control input-lg dynamic" data-dependent="state">
		    	<option value="">NULL</option>
		    		@foreach(App\khoa::all() as $key)
		    	<option value="{{ $key ->MaKhoa}}">{{ $key ->TenKhoa }}</option>
		     		@endforeach

		    </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection