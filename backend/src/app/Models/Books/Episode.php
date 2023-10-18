<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasUuids;

    protected $fillable = [
        'book_id',
        'is_prologue',
        'summary'
    ];

    public function i18n()
    {
        return $this->hasMany(EpisodeI18n::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}
