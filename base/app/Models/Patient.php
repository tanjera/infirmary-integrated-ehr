<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Patient extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name_first',
        'name_middle',
        'name_last',
        'name_preferred',

        'date_of_birth',
        'medical_record_number',

        'sex',
        'gender',
        'pronouns',

        'code_status',
        'address',
        'telephone',
    ];
}
