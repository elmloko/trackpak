<?php

namespace App\Exports;

use App\Models\Package;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PackageExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        // Obtén los datos de los paquetes desde el modelo Package
        $packages = Package::all();

        return view('packages.export', [
            'packages' => $packages
        ]);
    }
}
