<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
    static $rules = [
		// 'CODIGO' => 'required',
		'DESTINATARIO' => 'required',
    'CUIDAD' => 'required',
    'VENTANILLA' => 'required|in:DND,DD,ECA,CASILLAS,UNICA',
    // 'ZONA' => 'required_if:VENTANILLA,DND|string|max:255',
		// 'TELEFONO' => 'required',
		// 'PAIS' => 'required',
		// 'CUIDAD' => 'required',
		// 'PESO' => 'required',
		// 'TIPO' => 'required',
		// 'ESTADO' => 'required',
    // 'ADUANA' => 'required',
    // 'ISO' => 'required',
    // 'date_redirigido' => 'required',
    // 'redirigido' => 'required'
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['CODIGO','DESTINATARIO','TELEFONO','PAIS','CUIDAD','ZONA','VENTANILLA','PESO','TIPO','ESTADO','ADUANA','ISO','PRECIO','OBSERVACIONES','date_redirigido','redirigido','nrocasilla','usercartero'];



}
