<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class danhSachHuy extends Model
{
    protected $fillable =['MaSV', 'TenSV', 'MaDot', 'MaNganh', 'Diem', 'Tinchi', 'NN', 'Tudo'];
}
