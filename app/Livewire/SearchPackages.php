<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;

class SearchPackages extends Component
{
    public $search = '';

    public function render()
    {
        $package = Package::where('CODIGO', 'like', '%' . $this->search . '%')
            ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
            ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
            ->orWhere('PAIS', 'like', '%' . $this->search . '%')
            ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
            ->orWhere('ZONA', 'like', '%' . $this->search . '%')
            ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
            ->orWhere('PESO', 'like', '%' . $this->search . '%')
            ->orWhere('TIPO', 'like', '%' . $this->search . '%')
            ->orWhere('ESTADO', 'like', '%' . $this->search . '%')
            ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
            ->orWhere('created_at', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.search-packages', ['packages' => $package]);
    }
    public function update(Request $request, Package $package)
    {
        request()->validate(Package::$rules);

        $package->update($request->all());

        return redirect()->route('packages.index')
            ->with('success', 'Paquete Actualizado Con Exito!');
    }
    public function index()
    {
        $packages = Package::paginate(20);

        return view('package.index', compact('packages'))
            ->with('i', (request()->input('page', 1) - 1) * $packages->perPage());
    }
}

