<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class danhSachChinhThuc extends Model
{
    protected $fillable  = ['MaSV', 'TenSV', 'MaNganh', 'MaDot', 'Lop', 'Rank', 'TrangThai',];
}
