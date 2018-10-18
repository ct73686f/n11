<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MovementCash extends Model
{
    use Sortable;

    protected $table = 'movements_cash';

    protected $fillable = [
        'document_cash_id',
        'description',
        'amount'
    ];

    public $sortable = [
        'id',
        'document_cash_id',
        'description',
        'amount'
    ];

    public function document()
    {
        return $this->belongsTo('App\Models\DocumentCash', 'document_cash_id', 'id');
    }
}
