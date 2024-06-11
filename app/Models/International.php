<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class International extends Model
{
    use SoftDeletes;

    static $rules = [
    ];

    protected $perPage = 20;
    
    protected $fillable = ['CODIGO','DESTINATARIO','TELEFONO','PAIS','CUIDAD','ZONA','VENTANILLA','PESO','TIPO','ADUANA','ESTADO','ISO','PRECIO','OBSERVACIONES','usercartero'];



}
