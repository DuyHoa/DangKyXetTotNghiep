<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class khoa extends Model
{
    protected $fillable = ['MaKhoa','TenKhoa','Khoas_MaKhoa',];
}
