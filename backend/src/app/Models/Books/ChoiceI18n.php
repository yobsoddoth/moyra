<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ChoiceI18n extends Model
{
    use HasUuids;

    protected $table = 'choices_i18n';
    protected $fillable = [
        'language_id',
        'creator_id',
        'content',
    ];
}
