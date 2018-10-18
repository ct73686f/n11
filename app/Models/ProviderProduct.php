<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderProduct extends Model
{

    protected $table = 'provider_product';

    protected $fillable = [
        'provider_id',
        'product_id'
    ];


}
