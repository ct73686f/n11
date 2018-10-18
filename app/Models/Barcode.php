<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{

    protected $table = 'bar_codes';

    protected $fillable = [
        'product_id',
        'code'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

}
