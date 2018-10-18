<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class StoreCash extends Model
{
    use Sortable;

    protected $table = 'store_cash';

    protected $fillable = [
        'amount',
    ];

    public $sortable = [
        'id',
        'amount',
        'created_at',
        'updated_at'
    ];

}
