<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'patient',
        'ordered_by',
        'cosigned_by',
        'cosign_complete',
        'status',
        'category',
        'method',
        'priority',
        'start_time',
        'end_time',

        'note',

        'drug',
        'dose_amount',
        'dose_unit',
        'route',
        'period_amount',
        'period_unit',
        'total_doses',
        'indication'
    ];

    public static array $status_index = ['active', 'pending', 'discontinued', 'completed'];
    public static array $category_index = ['general', 'medication'];
    public static array $method_index = ['written', 'verbal', 'telephone', 'protocol'];
    public static array $priority_index = ['routine', 'now', 'stat'];
    public static array $doseunits_index = [
        'l', 'ml',
        'g', 'mg', 'mcg',
        'meq', 'iu',
        'puff', 'gtt',
        'ml_hr', 'mcg_hr',
        'ml_kg_hr', 'mcg_kg_hr'
    ];
    public static array $route_index = [ 'po', 'iv', 'im', 'subcut', 'inhaled'];
    public static array $periodtype_index = ['repeats', 'once', 'prn'];
    public static array $periodunit_index = ['minute', 'hour', 'day', 'week'];
}
