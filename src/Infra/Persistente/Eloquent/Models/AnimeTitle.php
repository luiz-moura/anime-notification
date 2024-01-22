<?php

namespace Infra\Persistente\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class AnimeTitle extends Model
{
    public $timestamps = false;
    protected $table = 'anime_titles';
    protected $fillable = [
        'title',
        'type',
        'anime_id',
    ];
}
