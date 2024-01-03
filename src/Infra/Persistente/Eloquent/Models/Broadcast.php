<?php

namespace Infra\Persistente\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    protected $table = 'broadcasts';

    public $timestamps = false;

    protected $fillable = [
        'anime_id',
        'day',
        'time',
        'timezone',
        'date_formatted',
    ];
}
