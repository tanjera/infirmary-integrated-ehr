<?php

namespace App\Models\Chart;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DiagnosticAttachment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'report',
        'name',
        'mimetype',
        'filepath',
    ];
}
