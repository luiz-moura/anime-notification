<?php

namespace Infra\Persistente\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Anime extends Model
{
    protected $table = 'animes';

    protected $fillable = [
        'mal_id',
        'mal_url',
        'title',
        'slug',
        'approved',
        'airing',
        'type',
        'source',
        'episodes',
        'status',
        'duration',
        'rating',
        'synopsis',
        'background',
        'season',
        'year',
        'aired_from',
        'aired_to',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class);
    }
}
