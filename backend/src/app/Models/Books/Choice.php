<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasUuids;

    protected $fillable = [
        'episode_id',
        'towards_episode_id',
        'summary',
    ];

    public function i18n()
    {
        return $this->hasMany(ChoiceI18n::class);
    }

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}
