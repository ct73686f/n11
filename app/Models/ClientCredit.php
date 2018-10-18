<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Carbon\Carbon;

class ClientCredit extends Model
{
    use Sortable;

    protected $table = 'client_credit';

    protected $fillable = [
        'credit_type_id',
        'client_id',
        'amount',
        'start_date',
        'end_date'
    ];

    public $sortable = [
        'id',
        'description',
        'term',
        'amount'
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'id', 'client');
    }

    public function creditType()
    {
        return $this->belongsTo('App\Models\CreditType', 'credit_type_id', 'id');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'id', 'credit_type_id');
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function getStartDateAttribute() {
        return Carbon::parse($this->attributes['start_date'])->format('d/m/Y');
    }

    public function getEndDateAttribute() {
        return Carbon::parse($this->attributes['end_date'])->format('d/m/Y');
    }
}
