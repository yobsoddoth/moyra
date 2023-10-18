<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasUuids;

    protected $fillable = ['author_id'];

    public function i18n()
    {
        return $this->hasMany(BookI18n::class);
    }
}
