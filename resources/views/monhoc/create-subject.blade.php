@extends('home')

@section('content')
@if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors ->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ url('monhoc') }}" method="POST" role="form">
    {{ csrf_field()}}
    <div class="form-group">
        <label for="">Mã môn học</label>
        <input type="text" name="MaMon" class="form-control" id="" placeholder="Input field">
    </div>
    <div class="form-group">
        <label for="">Tên môn học</label>
        <input type="text" name="TenMon" class="form-control" id="" placeholder="Input field">
    </div>
    <div class="form-group">
        <label for="">số tin chỉ</label>
        <input type="text" name="TinChi" class="form-control" id="" placeholder="Input field">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection

@section('sub-title')
<div class="sub-title">
    <a>Tạo môn học</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
    <a>Quản lý Môn Học</a>
</div>
@endsection