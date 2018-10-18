<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PaymentMethod extends Model
{
    use Sortable;

    protected $table = 'payment_methods';

    protected $fillable = [
        'invoice_id',
        'description',
        'amount'
    ];

    public $sortable = [
        'id',
        'description',
        'amount'
    ];
}
