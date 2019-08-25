<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sinhvien_has_nganh extends Model
{
    protected $fillable = ['SinhViens_MaSV','Nganhs_MaNganh','Nganhs_Khoas_MaKhoa', ];
}
