<?php

namespace App\Models\Chart\MAR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Dose extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'patient',
        'order',
        'due_at',
        'status',
        'status_by',
        'note'
        ];

    public static array $status_index = ['due', 'not_given', 'given'];
}
