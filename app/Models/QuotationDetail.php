<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class QuotationDetail extends Model
{
    use Sortable;

    protected $table = 'quotation_details';

    protected $fillable = [
        'quotation_id',
        'product_id',
        'cost_id',
        'unit_price',
        'unit_cost',
        'quantity',
        'sub_total'
    ];

    public $sortable = [
        'id',
        'quotation_id',
        'product_id',
        'quantity',
        'unit_price',
        'unit_cost',
        'sub_total'
    ];

    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation', 'quotation_id', 'id');
    }

    public function product(){
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
