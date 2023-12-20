<?php

namespace Infra\Persistente\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class AnimeTitle extends Model
{
    protected $table = 'anime_titles';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'type',
        'anime_id'
    ];
}
