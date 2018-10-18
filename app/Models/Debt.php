<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Debt extends Model
{
    use Sortable;

    protected $dates = ['payment_date'];

    protected $table = 'debts';

    protected $fillable = [
        'provider_id',
        'payment_date',
        'amount',
        'status'
    ];

    public $sortable = [
        'id',
        'provider_id',
        'payment_date',
        'amount',
        'status',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function client()
    {
        return $this->hasOne('App\Models\Client', 'id', 'client_id');
    }

    public function creditType()
    {
        return $this->hasOne('App\Models\CreditType', 'id', 'credit_type_id');
    }

    public function invoice()
    {
        return $this->hasOne('App\Models\Invoice', 'id', 'invoice_id');
    }

    public function provider()
    {
        return $this->hasOne('App\Models\Provider', 'id', 'provider_id');
    }

    public function getPaymentDateAttribute($value)
    {
        /*if ($this->attributes['status'] == 'Y') {
            ;
            return Carbon::parse($value)->format('d/m/Y');
        }


        return '--/--/----';*/

        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getFieldPaymentDateAttribute()
    {
        return Carbon::parse($this->attributes['payment_date'])->format('d/m/Y');
    }

    public function getStatusAttribute()
    {
        return ($this->attributes['status'] == 'Y' ? 'Activa' : 'Inactiva');
    }

    public function getRawStatusAttribute()
    {
        return $this->attributes['status'];
    }

    public function setPaymentDateAttribute($value)
    {
        $this->attributes['payment_date'] = Carbon::createFromFormat('d/m/Y', $value);
    }
}
