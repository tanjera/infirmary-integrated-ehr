<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Allergy extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'patient',
        'allergen',
        'reaction',
        'severity',
        'notes',
    ];
    public static array $severity_index = ['none', 'mild', 'moderate', 'severe'];

}
