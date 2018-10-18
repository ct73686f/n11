<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Provider extends Model
{
    use Sortable;

    protected $table = 'providers';

    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'contact',
        'website',
        'additional_info'
    ];

    public $sortable = [
        'id',
        'name',
        'phone',
        'address',
        'email',
        'contact',
        'website',
        'additional_info',
        'created_at'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'provider_product', 'provider_id', 'product_id')->withTimestamps();
    }

    public function debts()
    {
        return $this->hasMany('App\Models\Debt', 'provider_id', 'id');
    }

    public function scopeLike($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%$value%");
    }

}
