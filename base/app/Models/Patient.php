<?php

namespace App\Models;

use App\Models\Allergy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Patient extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'active',
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

        'insurance_provider',
        'insurance_account_number',

        'next_of_kin_name',
        'next_of_kin_relationship',
        'next_of_kin_address',
        'next_of_kin_telephone',
    ];

    protected $casts = [
        'date_of_birth' => 'datetime'
    ];

    public static array $code_status_index = ['full', 'dnr', 'dnr_dni', 'palliative'];
    public static array $code_status_text = [
        'Full Code',
        'DNR (No CPR)',
        'DNR & DNI (Medical Only)',
        'Palliative (Natural Death)'
    ];
    public function textCodeStatus() : string
    {
        $key = array_search($this->code_status, self::$code_status_index);
        if ($key === false)
            return 'Full Code';
        else
            return self::$code_status_text[$key];
    }
    public static array $gender_index = ['unknown', 'female', 'male', 'transgender', 'non_binary'];
    public static array $gender_text = [
        'Unknown',
        'Female',
        'Male',
        'Transgender',
        'Non Binary',
    ];
    public function textGender() : string
    {
        $key = array_search($this->gender, self::$gender_index);
        if ($key === false)
            return 'Unknown';
        else
            return self::$gender_text[$key];
    }
    public static array $pronouns_index = ['unknown', 'she_her', 'he_him', 'they_them'];
    public static array $pronouns_text = [
        'Unknown',
        'She/Her',
        'He/Him',
        'They/Them',
        ];
    public function textPronouns() : string
    {
        $key = array_search($this->pronouns, self::$pronouns_index);
        if ($key === false)
            return 'Unknown';
        else
            return self::$pronouns_text[$key];
    }
    public function getAllergies() : Collection {
        $allergies = Allergy::where('patient', $this->id)->get();
        return $allergies;
    }
}
