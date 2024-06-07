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
        'TRASPORTE' => 'required',
    ];

    protected $table = 'bags';
    protected $perPage = 20;

    protected $fillable = [
        'NRODESPACHO', 'NROSACA', 'OFCAMBIO', 'OFDESTINO',
        'PESO', 'PAQUETES', 'ITINERARIO', 'ESTADO', 'TRASPORTE', 'FIN',
        'HORARIO', 'OBSERVACIONES', 'PESOF', 'MARBETE', 'OFCAM108',
        'OFDES108', 'RECEPTACULO', 'NFACTURA', 'ano_creacion', 'fecha_exp',
        'TIPO', 'SACAR', 'SACAM', 'PESOR', 'PESOM', 'PAQUETESR', 'PAQUETESM',
        'T', 'userbags','first','SACAU','PESOU','PAQUETESU'
    ];

    public function packagesHasBag()
    {
        return $this->hasMany('App\Models\PackagesHasBag', 'bags_id', 'id');
    }
}
