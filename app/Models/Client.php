<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Client extends Model
{
    use Sortable;

    protected $table = 'clients';
    protected $appends = 'full_name';

    protected $fillable = [
        'first_name',
        'last_name',
        'nit',
        'phone',
        'address'
    ];

    public $sortable = [
        'id',
        'first_name',
        'last_name',
        'phone',
        'address'
    ];

    public function getFullNameAttribute()
    {
        return "{$this->attributes['first_name']} {$this->attributes['last_name']}";
    }


    public function creditType()
    {
        return $this->hasOne('App\Models\Movement', 'document_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice', 'client_id', 'id');
    }

    public function accountsReceivables()
    {
        return $this->hasMany('App\Models\AccountsReceivable', 'client_id', 'id');
    }

    public function credit()
    {
        return $this->hasOne('App\Models\ClientCredit', 'client_id', 'id');
    }
}
