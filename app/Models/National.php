<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class National
 *
 * @property $id
 * @property $CODIGO
 * @property $NOMBRESDESTINATARIO
 * @property $NOMBRESREMITENTE
 * @property $TELEFONODESTINATARIO
 * @property $TELEFONOREMITENTE
 * @property $CIDESTINATARIO
 * @property $CIREMITENTE
 * @property $CANTIDAD
 * @property $TIPOSERVICIO
 * @property $TIPOCORRESPONDENCIA
 * @property $PESO
 * @property $DESTINO
 * @property $FACTURA
 * @property $IMPORTE
 * @property $ESTADO
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class National extends Model
{
    
    static $rules = [
		'CODIGO' => 'required',
		'NOMBRESDESTINATARIO' => 'required',
		'NOMBRESREMITENTE' => 'required',
		// 'TELEFONODESTINATARIO' => 'required',
		// 'TELEFONOREMITENTE' => 'required',
		// 'CIDESTINATARIO' => 'required',
		// 'CIREMITENTE' => 'required',
		'CANTIDAD' => 'required',
		'TIPOSERVICIO' => 'required',
		'TIPOCORRESPONDENCIA' => 'required',
		'PESO' => 'required',
		'DESTINO' => 'required',
		'FACTURA' => 'required',
		'IMPORTE' => 'required',
		// 'ESTADO' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [	'CODIGO',
							'NOMBRESDESTINATARIO',
							'NOMBRESREMITENTE',
							// 'TELEFONODESTINATARIO',
							// 'TELEFONOREMITENTE',
							// 'CIDESTINATARIO',
							// 'CIREMITENTE',
							'CANTIDAD',
							'TIPOSERVICIO',
							'TIPOCORRESPONDENCIA',
							'PESO',
							'DESTINO',
							'FACTURA',
							// 'ESTADO',
							'IMPORTE'];
							



}
