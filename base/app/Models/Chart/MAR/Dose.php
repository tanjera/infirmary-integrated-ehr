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
        'status_at',
        'status_by',
        'note'
        ];

    protected $casts = [
        'due_at' => 'datetime',
        'status_at' => 'datetime'
    ];

    public static array $status_index = ['due', 'not_given', 'given'];
    public static array $status_text = [
        'Due', 'Not Given', 'Given'
    ];
    public function textStatus() : string
    {
        $key = array_search($this->status, self::$status_index);
        if ($key === false)
            return 'Due';
        else
            return self::$status_text[$key];
    }
}
