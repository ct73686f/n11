<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Cost extends Model
{
    use Sortable;

    protected $table = 'costs';
    protected $appends = ['cost_value', 'price_values'];

    protected $fillable = [
        'product_id',
        'unit_price',
        'unit_cost',
        'wholesale_price'
    ];

    public $sortable = [
        'id',
        'product_id',
        'unit_price',
        'unit_cost',
        'wholesale_price',
        'created_at'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory', 'id', 'cost_id');
    }

    public function getCostValueAttribute()
    {
        return "Precio Unitario: {$this->attributes['unit_price']} - Costo Unitario: {$this->attributes['unit_cost']} - Precio por Mayor: {$this->attributes['wholesale_price']}";
    }

    public function getPriceValuesAttribute()
    {
        $prices = [
            [''],
            ['id' => 'UP', 'name' => 'Precio Unitario: ' . $this->attributes['unit_price']],
            ['id' => 'WS', 'name' => 'Precio por Mayor: ' . $this->attributes['wholesale_price']]
        ];

        return $prices;
    }
}
