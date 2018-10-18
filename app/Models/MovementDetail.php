<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MovementDetail extends Model
{
    use Sortable;

    protected $table = 'movement_details';

    protected $fillable = [
        'movement_id',
        'user_id',
        'document_id',
        //'provider_id',
        'product_id',
        'cost_id',
        'quantity',
        'price',
        'cost',
    ];

    public $sortable = [
        'id',
        'movement_id',
        'user_id',
        'document_id',
        //'provider_id',
        'product_id',
        'cost_id',
        'quantity',
        'price',
        'cost',
        'created_at',
    ];

    public function movement()
    {
        return $this->belongsTo('App\Models\Movement', 'id', 'movement_id');
    }

    public function inventory()
    {
        return $this->hasOne('App\Models\Inventory', 'id', 'inventory_id');
    }

    public function product() {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function getSubTotalAttribute()
    {
        $subTotal = ($this->attributes['quantity'] * $this->price);
        return number_format($subTotal, 2, '.', ',');
    }
}
