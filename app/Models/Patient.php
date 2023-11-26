<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'IdCard',
        'Gender',
        'Name',
        'Surname',
        'DateOfBirth',
        'Address',
        'Postcode',
        'ContactNumber1',
        'ContactNumber2',
    ];

    public function nextOfKin()
    {
        return $this->hasMany(NextOfKin::class);
    }

    public function medicalCondition()
    {
        return $this->hasMany(MedicalCondition::class);
    }

    public function medication()
    {
        return $this->hasMany(medication::class);
    }

    public function allergy()
    {
        return $this->hasMany(allergy::class);
    }
}
