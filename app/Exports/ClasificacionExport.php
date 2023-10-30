<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ClasificacionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $packages;

    public function __construct($packages)
    {
        $this->packages = $packages;
    }

    public function collection()
    {
        return $this->packages;
    }
}
