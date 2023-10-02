<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Package
 *
 * @property $id
 * @property $CODIGO
 * @property $DESTINATARIO
 * @property $TELEFONO
 * @property $PAIS
 * @property $CUIDAD
 * @property $ZONA
 * @property $VENTANILLA
 * @property $PESO
 * @property $TIPO
 * @property $ESTADO
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Package extends Model
{
    
    static $rules = [
		'CODIGO' => 'required',
		'DESTINATARIO' => 'required',
		'TELEFONO' => 'required',
		'PAIS' => 'required',
		'CUIDAD' => 'required',
		'ZONA' => 'required',
		'VENTANILLA' => 'required',
		'PESO' => 'required',
		'TIPO' => 'required',
		'ESTADO' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['CODIGO','DESTINATARIO','TELEFONO','PAIS','CUIDAD','ZONA','VENTANILLA','PESO','TIPO','ESTADO'];



}
