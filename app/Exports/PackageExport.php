<?php

namespace App\Exports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PackageExport implements FromCollection
{
    public function collection(){
        return Package::all();
    }
}

