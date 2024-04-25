<?php

namespace App\Models\Chart;

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
        'status_by',
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
        'period_type',
        'period_amount',
        'period_unit',
        'total_doses',
        'indication'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
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
        'ml_kg_hr', 'mcg_kg_hr', 'mcg_kg_min'
    ];
    public static array $doseunits_text = [
        'L', 'mL',
        'gm', 'mg', 'mcg',
        'mEq', 'IU',
        'Puff', 'gtt',
        'mL/hr', 'mcg/hr',
        'mL/kg/hr', 'mcg/kg/hr', 'mcg/kg/min'
        ];
    public function textDoseunit() : string
    {
        $key = array_search($this->dose_unit, self::$doseunits_index);
        if ($key === false)
            return 'L';
        else
            return self::$doseunits_text[$key];
    }
    public static array $routes_index = [ 'po', 'iv', 'im', 'subcut', 'inhaled'];
    public static array $routes_text = [
        'PO', 'IV', 'IM', 'Subcutaneous', 'Inhaled'
    ];
    public function textRoute() : string
    {
        $key = array_search($this->route, self::$routes_index);
        if ($key === false)
            return 'PO';
        else
            return self::$routes_text[$key];
    }
    public static array $periodtypes_index = ['repeats', 'once', 'prn'];
    public static array $periodtypes_text = [
        'Repeats', 'Once', 'PRN'
    ];
    public function textPeriodtype() : string
    {
        $key = array_search($this->route, self::$periodtypes_index);
        if ($key === false)
            return 'Repeats';
        else
            return self::$periodtypes_text[$key];
    }
    public static array $periodunits_index = ['minute', 'hour', 'day', 'week'];
    public static array $periodunits_text = [
        'Minutes', 'Hours', 'Days', 'Weeks'
    ];
    public function getPeriodMinutes() : int
    {
        switch ($this->period_unit) {
            default:
            case 'minute':
                return $this->period_amount;

            case 'hour':
                return $this->period_amount * 60;

            case 'day':
                return $this->period_amount * 60 * 24;

            case 'week':
                return $this->period_amount * 60 * 24 * 7;
        }
    }
}
