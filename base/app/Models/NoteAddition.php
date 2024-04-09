<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class NoteAddition extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'note',
        'author',
        'body',
    ];
}
