<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Note extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'patient',
        'author',
        'category',
        'body',
    ];
    public static array $category_index = ['progress', 'nursing', 'history_physical', 'plan_of_care'];
    public static array $category_text = [
        'Progress Note',
        'Nursing Note',
        'History & Physical',
        'Plan of Care',
    ];
    public function textCategory() : string
    {
        $key = array_search($this->category, self::$category_index);
        if ($key === false)
            return 'Progress Note';
        else
            return self::$category_text[$key];
    }
}
