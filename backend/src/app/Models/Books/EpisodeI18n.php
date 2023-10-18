<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EpisodeI18n extends Model
{
    use HasUuids;

    protected $table = 'episodes_i18n';
    protected $fillable = [
        'language_id',
        'creator_id',
        'content',
    ];

}
