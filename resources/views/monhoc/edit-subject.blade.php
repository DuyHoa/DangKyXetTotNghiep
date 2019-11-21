@extends('home')

@section('sub-title')
<div class="sub-title">
    <a>Cập nhật môn học</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
    <a>Quản lý Môn Học</a>
</div>
@endsection

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
<form action="{{ URL::to('/monhoc/update') }}" method="POST" role="form">
        
    {{ csrf_field() }}
    <div class="form-group">
        <label for="">Mã môn học</label>
        <input type="text" name="MaMon" class="form-control" id="" placeholder="Input field" value="{{ $monhoc->MaMon }}">
    </div>
    <div class="form-group">
        <label for="">Tên môn học</label>
        <input type="text" name="TenMon" class="form-control" id="" placeholder="Input field" value="{{ $monhoc->TenMon }}">
    </div>
    <div class="form-group">
        <label for="">số tin chỉ</label>
        <input type="text" name="TinChi" class="form-control" id="" placeholder="Input field" value="{{ $monhoc->TinChi }}">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
@endsection