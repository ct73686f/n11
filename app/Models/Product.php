<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use Sortable;

    protected $table = 'products';

    protected $fillable = [
        'description',
        'image',
        'thumbnail',
    ];

    public $sortable = [
        'id',
        'description',
        'image',
    ];

    public function inventory()
    {
        return $this->hasOne('App\Models\Inventory', 'product_id', 'id');
    }

    public function movementDetail()
    {
        return $this->belongsTo('App\Models\MovementDetail', 'id', 'product_id');
    }

    public function providers()
    {
        return $this->belongsToMany('App\Models\Provider', 'provider_product', 'product_id',
            'provider_id')->withTimestamps();
    }

    public function getProviderAttribute()
    {
        return $this->providers->first();
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'product_category', 'product_id',
            'category_id')->withTimestamps();
    }

    public function scopeLike($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%$value%");
    }

    public function scopeCategory($query, $id)
    {
        return $query->whereHas('categories', function ($query) use ($id) {
            $query->where('category_id', $id);
        });
    }

    public function scopeProvider($query, $id)
    {
        return $query->whereHas('providers', function ($query) use ($id) {
            $query->where('provider_id', $id);
        });
    }

    public function costs()
    {
        return $this->hasMany('App\Models\Cost', 'product_id', 'id');
    }

    public function cost()
    {
        return $this->hasOne('App\Models\Cost', 'product_id', 'id');
    }

    public function barcodes()
    {
        return $this->hasMany('App\Models\Barcode', 'product_id', 'id');
    }

    public function invoiceDetails()
    {
        return $this->hasMany('App\Models\InvoiceDetail', 'product_id', 'id');
    }

    public function movementDetails()
    {
        return $this->hasMany('App\Models\MovementDetail', 'product_id', 'id');
    }

    public function barcode()
    {
        return $this->hasOne('App\Models\Barcode', 'product_id', 'id');
    }
}
