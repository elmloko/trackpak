<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class National extends Model
{
    public function cartero()
    {
        return $this->belongsTo(User::class, 'cartero_id');
    }
    static $rules = [
		'CODIGO' => 'required',
		'NOMBRESDESTINATARIO' => 'required',
		'NOMBRESREMITENTE' => 'required',
		'TELEFONODESTINATARIO' => 'required',
    	'TELEFONOREMITENTE' => 'required',
    	'CIDESTINATARIO' => 'required',
    	'CIREMITENTE' => 'required',
    	'ESTADO' => 'required',
		'CANTIDAD' => 'required',
		'TIPOSERVICIO' => 'required',
		'TIPOCORRESPONDENCIA' => 'required',
		'PESO' => 'required',
		'DESTINO' => 'required',
		'FACTURA' => 'required',
		'IMPORTE' => 'required',
		'DIRECCION' => 'required',
		'PROVINCIA' => 'required',
		'DESCRIPCION' => 'required',
		// 'MUNICIPIO' => 'required',
		// 'ORIGEN' => 'required',
		// 'ESTADO' => 'required',
    ];

    protected $perPage = 20;

    protected $fillable = [	'CODIGO',
							'NOMBRESDESTINATARIO',
							'NOMBRESREMITENTE',
							'TELEFONODESTINATARIO',
							'TELEFONOREMITENTE',
							'CIDESTINATARIO',
							'CIREMITENTE',
							'CANTIDAD',
							'TIPOSERVICIO',
							'TIPOCORRESPONDENCIA',
							'PESO',
							'DESTINO',
							'FACTURA',
							'ESTADO',
							'IMPORTE',
							'DIRECCION',
							'MUNICIPIO',
							'ORIGEN',
							'PROVINCIA',
							'USER',
							'DESCRIPCION',
							'OBSERVACION',
							'datedespachocartero',
							'cartero_id'
							];
}
