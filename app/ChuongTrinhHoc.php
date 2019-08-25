<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChuongTrinhHoc extends Model
{
    protected $fillable  = ['MaMon', 'TenMon','Tinchi','Term','Nganh','khoa', 'khoas'];
}
