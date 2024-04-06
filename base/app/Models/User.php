<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'active',
        'name',
        'email',
        'password',
        'role',
        'license'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public static array $roles_index = ['clinician', 'manager', 'administrator'];
    public static array $licenses_index = ['none', 'ma', 'cna', 'lpn', 'rn', 'np', 'pa', 'md', 'do'];
    public static array $licenses_text = [
        'None',
        'Medical Assistant',
        'Certified Nursing Assistant',
        'Licensed Practical Nurse',
        'Registered Nurse',
        'Nurse Practitioner',
        "Physician's Assistant",
        'Medical Doctor',
        'Doctor of Osteopathy'];
    public function textLicense() : string
    {
        $key = array_search($this->license, self::$licenses_index);
        if ($key === false)
            return 'None';
        else
            return self::$licenses_text[$key];
    }
    public function canChart(): boolean
    {
        return in_array($this->license, ['ma', 'cna', 'lpn', 'rn', 'np', 'pa', 'md', 'do']);
    }
    public function canAssess(): boolean
    {
        return in_array($this->license, ['lpn', 'rn', 'np', 'pa', 'md', 'do']);
    }
    public function canOrder(): boolean
    {
        return in_array($this->license, ['np', 'pa', 'md', 'do']);
    }
}
