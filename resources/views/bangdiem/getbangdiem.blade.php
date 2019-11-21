@extends('home')

@section('sub-title')
<div class="sub-title">
  <a>Bảng điểm của sinh viên</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
  <a>Quản lý sinh viên</a>
</div>
@endsection


@section('content')
<div>
    @if(!empty($petani))
        <?php $i = 0; ?>
        @foreach($petani as $key)
            @if($i < 1)
                <table class="tbfull">
                    <tr>
                        <td><strong>Mã sinh viên: </strong><a class="clt-blue">{{ $key->MaSV }}</a></td>
                        <td><strong>Tên sinh viên: </strong><a class="clt-blue">{{ $key->TenSV }}</a></td>
                    </tr>
                    <tr>
                        <td><strong>Khoa: </strong><a class="clt-blue">{{ $key->MaKhoa }}</a></td>
                        <td><strong>Ngành: </strong><a class="clt-blue">{{ $key->MaNganh }}</a></td>
                    </tr>
                    <tr>
                        <td><strong>Khóa: </strong><a class="clt-blue">K{{ $key->Khoa }}</a></td>
                        <td><strong>Lớp: </strong><a class="clt-blue">{{ $key->Lop }}</a></td>
                    </tr>
                    <tr>
                        <td><strong>Tổng tín chỉ: </strong><a class="clt-blue">{{ $petani->sum('SoTC') }}</a></td>
                        <td><strong>Điểm trung bình: </strong><a class="clt-blue">{{ round($petani->avg('Diem'), 2) }}</a></td>
                    </tr>
                </table>
            @endif
            <?php $i++; ?>
        @endforeach
    @endif
</div>

<div>
    <table class="bangdiem-l">
        <tr>
            <th>Mã Môn</th>
            <th>Tên Môn</th>
            <th>Tín chỉ</th>
            <th>Điểm</th>
        </tr>
        @foreach($petani as $key)
        <tr>
            <td>{{ $key->MaMH }}</td>
            <td>{{ $key->TenMH }}</td>
            <td>{{ $key->SoTC }}</td>
            <td>{{ $key->Diem }}</td>
        </tr>
        @endforeach
        <tr class ="bdresult">
            <td></td>
            <td>Tổng kết</td>
            <td>{{ $petani->sum('SoTC') }}</td>
            <td>{{ $petani->avg('Diem') }}</td>
    </table>
</div>


<!-- <div class="form-group form-bangdiem">
	<p>Chọn sinh viên</p>
    <select name="bangdiem" id="bd" class="form-control input-lg dynamic" data-dependent="state">
    	<option value="">NULL</option>
    		@foreach($petani as $key)
    	<option value="{{ $key->SinhViens_MaSV}}">{{ $key->SinhViens_MaSV }}</option>
     		@endforeach
    </select>
</div>
<div><a class="add btn btn-success" href="{{URL('/bangdiem/importexcel')}}">Thêm mới</a></div>
<div>
	<table class="bangdiem-l">
	</table>
</div>
 -->

@endsection

@section('sub-title')
<div class="sub-title">
	Danh sách bảng điểm
</div>
@endsection