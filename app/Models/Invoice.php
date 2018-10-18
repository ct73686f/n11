<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Invoice extends Model
{
    use Sortable;

    protected $table = 'invoices';

    protected $fillable = [
        'user_id',
        'client_id',
        'payment_method_id',
        'credit_type_id',
        'nit',
        'void_status',
        'void_details',
        'description',
        'discount',
        'surcharge',
        'total'
    ];

    public $sortable = [
        'id',
        'user_id',
        'client_id',
        'payment_method_id',
        'credit_type_id',
        'nit',
        'description',
        'discount',
        'surcharge',
        'total'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function client()
    {
        return $this->hasOne('App\Models\Client', 'id', 'client_id');
    }

    public function getInvoiceNumberAttribute()
    {
        return "Factura No. {$this->attributes['id']}";
    }

    public function paymentMethods()
    {
        return $this->hasMany('App\Models\PaymentMethod', 'invoice_id', 'id');
    }

    public function accountsReceivables()
    {
        return $this->hasMany('App\Models\AccountsReceivable', 'invoice_id', 'id');
    }

    public function scopePaymentMethod($query, $paymentMethod = 'Credito')
    {
        return $query->whereHas('paymentMethods', function ($query) use ($paymentMethod) {
            $query->where('description', $paymentMethod);
        });
    }

    public function getTotalWithDiscountAttribute()
    {
        return ($this->attributes['total'] - $this->attributes['discount']);
    }

    /*public function paymentMethod()
    {
        return $this->hasOne('App\Models\PaymentMethod', 'id', 'payment_method_id');
    }

    public function creditType()
    {
        return $this->hasOne('App\Models\CreditType', 'id', 'credit_type_id');
    }*/

    public function invoiceDetails()
    {
        return $this->hasMany('App\Models\InvoiceDetail', 'invoice_id', 'id');
    }
}
