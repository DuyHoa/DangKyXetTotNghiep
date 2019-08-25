@extends('home')

@section('sub-title')
<div class="sub-title">
  <a>Tạo mới đợt xét</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
  <a>Quản lý đợt xét</a>
</div>
@endsection

@section('content')

@if($message = Session::get('success'))
    <div class ="alert alert-success">
        <p>{{$message}}</p>
    </div>
@endif
@if($message = Session::get('info'))
    <div class ="alert alert-info">
        <p>{{$message}}</p>
    </div>
@endif
@if($message = Session::get('remove'))
    <div class ="alert alert-warning">
        <p>{{$message}}</p>
    </div>
@endif
@if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors ->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ url('dotxet') }}" method="POST" role="form">
        {{ csrf_field()}}
        <div class="form-group">
            <label for="">Mã Đợt</label>
            <input type="text" name="MaDX" class="form-control" id="" placeholder="Input field">
        </div>
        <div class="form-group">
            <label for="">Tên Đợt</label>
            <input type="text" name="TenDX" class="form-control" id="" placeholder="Input field">
        </div>
        <div class="form-group">
            <label for="">Ngày bắt đầu</label>
            <input type="date" name="NgayBatDau" class="form-control" id="" placeholder="Input field">
        </div>
        <div class="form-group">
            <label for="">Ngày kết thúc</label>
            <input type="date" name="NgayKetThuc" class="form-control" id="" placeholder="Input field">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection