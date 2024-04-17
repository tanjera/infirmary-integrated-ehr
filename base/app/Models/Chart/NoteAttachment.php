<?php

namespace App\Models\Chart;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class NoteAttachment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'note',
        'name',
        'mimetype',
        'filepath',
    ];
}
