<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Quotation extends Model
{
    use Sortable;

    protected $table = 'quotations';

    protected $fillable = [
        'user_id',
        'client_id',
        'credit_type_id',
        'nit',
        'description',
        'discount',
        'surcharge',
        'total'
    ];

    public $sortable = [
        'id',
        'user_id',
        'client_id',
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

    public function getQuotationNumberAttribute()
    {
        return "Cotización No. {$this->attributes['id']}";
    }

    public function paymentMethods()
    {
        return $this->hasMany('App\Models\QuotationPaymentMethod', 'quotation_id', 'id');
    }

    public function quotationDetails()
    {
        return $this->hasMany('App\Models\QuotationDetail', 'quotation_id', 'id');
    }
}
