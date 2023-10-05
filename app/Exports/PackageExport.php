<?php

namespace App\Exports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PackageExport implements FromCollection
// class PackageExport implements FromView
{
    public function collection(){
        return Package::all();
    }
    // public function view(): View
    // {
    //     // Obtén los datos de los paquetes desde el modelo Package
    //     return view('packages', [
    //         'packages' => Package::all()
    //     ]);
    // }
}

