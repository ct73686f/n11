<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class InvoiceDetail extends Model
{
    use Sortable;

    protected $table = 'invoice_details';

    protected $fillable = [
        'invoice_id',
        'product_id',
        'cost_id',
        'unit_price',
        'unit_cost',
        'quantity',
        'sub_total'
    ];

    public $sortable = [
        'id',
        'invoice_id',
        'product_id',
        'quantity',
        'unit_price',
        'unit_cost',
        'sub_total'
    ];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'invoice_id', 'id');
    }

    public function product(){
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
