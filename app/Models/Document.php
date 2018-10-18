<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Document extends Model
{
    use Sortable;

    protected $table = 'documents';

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
                $output = 'Entrada de productos';
                break;

            case 'S':
                $output = 'Salida de productos';
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
        return $this->hasMany('App\Models\Movement', 'document_id', 'id');
    }
}
