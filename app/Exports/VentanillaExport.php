<?php

namespace App\Exports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\FromCollection;

class VentanillaExport implements FromCollection
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
