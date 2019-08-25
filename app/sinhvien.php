<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sinhvien extends Model
{
    protected $fillable = ['MaSV','TenSV', 'Khoas_MaKhoa', 'NgaySinh', 'MaKhoa', 'MaNganh', 'Lop', 'Khoa', 'DotXets_MaDX', ];
}
