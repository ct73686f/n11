<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class CreditType extends Model
{
    use Sortable;

    protected $table = 'credit_types';

    protected $fillable = [
        'description',
        'term',
        'amount'
    ];

    public $sortable = [
        'id',
        'description',
        'term',
        'amount'
    ];
}
