<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class DocumentCash extends Model
{
    use Sortable;

    protected $table = 'documents_cash';

    protected $fillable = [
        'description',
        'output_type'
    ];

    public $sortable = [
        'id',
        'description',
        'output_type'
    ];

    public function getOutputTypeAttribute($outputType)
    {
        $output = '';

        switch ($outputType) {
            case 'E':
                $output = 'Entrada Efectivo';
                break;

            case 'S':
                $output = 'Salida Efectivo';
                break;
        }

        return $output;
    }

    public function getRawOutputTypeAttribute()
    {
        return $this->attributes['output_type'];
    }




    public function movements()
    {
        return $this->hasMany('App\Models\MovementCash', 'document_id', 'id');
    }
}
