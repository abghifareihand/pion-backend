<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    protected $fillable = [
        'type',
        'title',
        'description',
        'image_path',
        'file_path'
    ];
}
