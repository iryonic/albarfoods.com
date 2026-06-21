<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaLibrary extends Model
{
    protected $table = 'media_library';

    protected $fillable = [
        'file_name',
        'file_path',
        'file_size',
        'file_type',
    ];
}
