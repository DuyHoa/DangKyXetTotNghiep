<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class statistic extends Model
{
    protected $fillable = ['year','MaKhoa','MaNganh', 'count'];
}
