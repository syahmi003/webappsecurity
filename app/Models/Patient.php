<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'patient _name',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone_number',
        'email',
        'address',
    ];

    // Mutator to concatenate first_name and last_name into patient_name
    public function setPatientNameAttribute()
    {
        if (isset($this->attributes['first_name']) && isset($this->attributes['last_name'])) {
            $this->attributes['patient_name'] = $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
        }
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = $value;
        $this->setPatientNameAttribute();
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = $value;
        $this->setPatientNameAttribute();
    }

}
