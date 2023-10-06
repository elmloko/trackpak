<?php

namespace App\Exports;

use App\Models\Pcertificate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PcertificateExport implements FromCollection
{
    public function collection(){
        return Pcertificate::all();
    }
}

