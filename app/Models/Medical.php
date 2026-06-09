<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
    use HasFactory;

    protected $table = 'medical';

    protected $fillable = [
        'record_id',
        'patient_name',
        'diagnosis',
        'treatment',
        'doctor',
        'date_of_record',
    ];
}
