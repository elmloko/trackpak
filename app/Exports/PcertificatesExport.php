<?php

namespace App\Exports;

use App\Models\Pcertificates;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PcertificatesExport implements FromCollection
{
    public function collection(){
        return Pcertificates::all();
    }
}

