<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'bill_date',
        'delivery_date',
        'payment_deadline',
        'patient_name',
        'billing_address',
        'contact_info',
        'email',
        'subtotal',
        'vat_total',
        'total_amount',
        'payment_status'
    ];

    public function items()
    {
    return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }


}
