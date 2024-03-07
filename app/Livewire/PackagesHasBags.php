<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PackagesHasBag;
use Livewire\WithPagination;

class PackagesHasBags extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $packagesHasBags = PackagesHasBag::where('bags_id', 'like', '%' . $this->search . '%')
            ->orWhere('packages_id', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.packages-has-bags', [
            'packagesHasBags' => $packagesHasBags,
        ]);
    }
}
