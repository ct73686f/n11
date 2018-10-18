<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Inventory extends Model
{
    use Sortable;

    protected $table = 'inventory';

    protected $fillable = [
        'user_id',
        //'provider_id',
        'product_id',
        'cost_id',
        'initial',
        'entry',
        'output',
        'current',
    ];

    public $sortable = [
        'id',
        'user_id',
        'product_id',
        'cost_id',
        'current',
    ];

    public function movementDetail()
    {
        return $this->belongsTo('App\Models\MovementDetail', 'id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function cost()
    {
        return $this->hasOne('App\Models\Cost', 'id', 'cost_id');
    }


}
