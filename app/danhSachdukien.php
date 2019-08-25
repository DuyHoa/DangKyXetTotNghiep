<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class danhSachdukien extends Model
{
    protected $fillable  = ['MaSV', 'TenSV', 'MaNganh', 'MaDot', 'Lop', 'TinhTrang', 'isDat',];
}
