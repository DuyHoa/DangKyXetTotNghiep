@extends('home')
@section('content')
<div class="import_BD">
    <p>Chọn file excel bảng điểm</p>
    <div class="alert alert-info" style="margin-top: 15px;">
        <ul class="import-info">
            <li>Bảng điểm có định dạng excel</li>
            <li>Gồm 5 trường thứ tự (Mã sinh viên, Mã môn học, Tên môn học, Tín chỉ môn học, Điểm môn học)</li>
            <li>Tên header của các trường lần lượt là MaSV, MaMon, TenMon, TC, Diem</li>
        </ul>
    </div>
    <form style="border: 4px solid #e8e7e7; margin-top: 15px;padding: 10px; display: flex; align-items: center; width: fit-content;" action="{{ url('importbangdiemsv') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
        @csrf
 
        @if ($errors->any())
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
 
        @if (Session::has('success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <p>{{ Session::get('success') }}</p>
            </div>
        @endif
 
        <input type="file" name="import_file" />
        <button class="btn btn-primary">Nhập file</button>
    </form>
</div>
@endsection

@section('sub-title')
<div class="sub-title">
    Nhập bảng điểm
</div>
@endsection
<style type="text/css">
    .import-info{
        padding-left: 15px;
    }
    .import-info>li{
        list-style: circle;
    }
</style>