<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Pcertificate
 *
 * @property $id
 * @property $CODIGO
 * @property $DESTINATARIO
 * @property $DIRECCION
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
class Pcertificate extends Model
{
    use SoftDeletes;
    static $rules = [
		'CODIGO' => 'required',
		'DESTINATARIO' => 'required',
		'DIRECCION' => 'required',
		'TELEFONO' => 'required',
		'PAIS' => 'required',
		'CUIDAD' => 'required',
		'ZONA' => 'required',
		'VENTANILLA' => 'required',
		'PESO' => 'required',
		'TIPO' => 'required',
		'ESTADO' => 'required',
		'ADUANA' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['CODIGO','DESTINATARIO','DIRECCION','TELEFONO','PAIS','CUIDAD','ZONA','VENTANILLA','PESO','TIPO','ESTADO','ADUANA'];



}
