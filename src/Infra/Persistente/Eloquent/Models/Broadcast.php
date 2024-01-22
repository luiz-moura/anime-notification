<?php

namespace Infra\Persistente\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    public $timestamps = false;
    protected $table = 'broadcasts';
    protected $fillable = [
        'anime_id',
        'day',
        'time',
        'timezone',
        'date_formatted',
    ];
}
