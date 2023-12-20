<?php

namespace Infra\Persistente\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genres';

    protected $fillable = [
        'name',
        'slug',
        'type',
        'explicit',
        'theme',
        'demographic',
        'mal_id',
        'mal_url',
    ];
}
