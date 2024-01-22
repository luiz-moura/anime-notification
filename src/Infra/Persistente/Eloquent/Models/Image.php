<?php

namespace Infra\Persistente\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = [
        'title',
        'path',
        'slug',
        'mimetype',
    ];
    protected $attributes = [
        'disk' => 'local',
    ];
}
