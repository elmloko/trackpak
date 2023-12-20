<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Mensaje
 *
 * @property $id
 * @property $estado
 * @property $mensajes
 * @property $observacion
 * @property $id_telefono
 * @property $fecha_creacion
 *
 * @property Package $package
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Mensaje extends Model
{
    
    static $rules = [
		'estado' => 'required',
		'mensajes' => 'required',
		'observacion' => 'required',
		'id_telefono' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['estado','mensajes','observacion','id_telefono','fecha_creacion'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function package()
    {
        return $this->hasOne('App\Models\Package', 'id', 'id_telefono');
    }
    

}
