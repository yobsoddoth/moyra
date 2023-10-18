<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class BookI18n extends Model
{
    use HasUuids;

    protected $table = 'books_i18n';
    protected $fillable = [
        'language_id',
        'creator_id',
        'title',
        'annotation',
    ];
}
