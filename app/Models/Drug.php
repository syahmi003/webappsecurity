<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    protected $table = 'drug'; // Link the model to the 'drug' table
    protected $fillable = ['drug_name', 'manufacture_date', 'expiry_date', 'price', 'quantity'];
}
