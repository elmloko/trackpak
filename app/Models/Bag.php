<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bag extends Model
{
    
    static $rules = [
        'NRODESPACHO' => 'required',
        'OFCAMBIO' => 'required',
        'OFDESTINO' => 'required',
        'NROSACAS' => 'required',
        'PESO' => 'required',
        'PAQUETES' => 'required',
        'ITINERARIO' => 'required',
        'ESTADO' => 'required',
    ];

    protected $perPage = 20;

    protected $fillable = ['NRODESPACHO', 'OFCAMBIO', 'OFDESTINO', 'NROSACAS', 'PESO', 'PAQUETES', 'ITINERARIO', 'ESTADO', 'ano_creacion'];

    public function packagesHasBag()
    {
        return $this->hasOne('App\Models\PackagesHasBag', 'bags_id', 'id');
    }

    // Mutador para 'NRODESPACHO'
    public function setNrodespachoAttribute($value)
    {
        $anoActual = now()->year;
        $ultimoNroDespacho = Bag::where('ano_creacion', $anoActual)->max('NRODESPACHO');
        $nuevoNroDespacho = $ultimoNroDespacho ? $ultimoNroDespacho + 1 : 1;
        $this->attributes['NRODESPACHO'] = str_pad($nuevoNroDespacho, 4, '0', STR_PAD_LEFT);
        $this->attributes['ano_creacion'] = $anoActual;

    }
}
