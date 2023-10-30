<?php

namespace App\Exports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\FromCollection;

class PackageExport implements FromCollection
{
    public function collection(){
        return Package::all();
    }
}

