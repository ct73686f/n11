<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use Sortable;

    protected $table = 'categories';

    protected $fillable = [
        'description'
    ];

    public $sortable = [
        'id',
        'description',
        'created_at'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_category', 'category_id',
            'product_id')->withTimestamps();
    }

    public function scopeLike($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%$value%");
    }
}
