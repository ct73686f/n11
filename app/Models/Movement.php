<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Movement extends Model
{
    use Sortable;

    protected $table = 'movements';

    protected $fillable = [
        'document_id',
        'user_id',
        'invoice_number',
        'total'
    ];

    public $sortable = [
        'id',
        'document_id',
        'user_id',
        'invoice_number',
        'total'
    ];

    public function details()
    {
        return $this->hasMany('App\Models\MovementDetail', 'movement_id', 'id');
    }

    public function document()
    {
        return $this->belongsTo('App\Models\Document', 'document_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\user', 'user_id', 'id');
    }
}
