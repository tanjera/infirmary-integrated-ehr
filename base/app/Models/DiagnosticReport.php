<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DiagnosticReport extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'patient',
        'author',
        'category',
        'body',
    ];

    public static array $category_index = ['ecg', 'x_ray', 'ct', 'mri', 'ultrasound', 'echocardiogram', 'other'];
    public static array $category_text = [
        'Electrocardiogram (ECG)',
        'X-Ray',
        'Computed Tomography (CT)',
        'Magnetic Resonance (MRI)',
        'Ultrasound',
        'Echocardiogram',
        'Other'
    ];
    public function textCategory() : string
    {
        $key = array_search($this->category, self::$category_index);
        if ($key === false)
            return 'Other';
        else
            return self::$category_text[$key];
    }
}
