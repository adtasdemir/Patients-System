<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'IdCard',
        'Name',
        'Surname',
        'ContactNumber1',
        'ContactNumber2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

}
