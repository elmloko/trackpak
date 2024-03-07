<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bag extends Model
{
    static $rules = [
        'NRODESPACHO' => 'required',
        'NROSACA' => 'required',
        'OFCAMBIO' => 'required',
        'OFDESTINO' => 'required',
        'NROSACAS' => 'required',
        'PESO' => 'required',
        'PAQUETES' => 'required',
        'ITINERARIO' => 'required',
        'ESTADO' => 'required',
    ];

    protected $table = 'bags';
    protected $perPage = 20;

    protected $fillable = ['NRODESPACHO', 'OFCAMBIO', 'OFDESTINO', 'NROSACAS', 'PESO', 'PAQUETES', 'ITINERARIO', 'ESTADO', 'ano_creacion','NROSACA','FIN'];

    public function packagesHasBag()
    {
        return $this->hasMany('App\Models\PackagesHasBag', 'bags_id', 'id');
    }
}
