<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class QuotationPaymentMethod extends Model
{
    use Sortable;

    protected $table = 'quotation_payment_methods';

    protected $fillable = [
        'quotation_id',
        'description',
        'amount'
    ];

    public $sortable = [
        'id',
        'description',
        'amount'
    ];
}
