<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable =[
      'path',
      'disk',
      'video_default_res',
      'video_default_format',
    ];
}
