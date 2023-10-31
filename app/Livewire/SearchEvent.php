<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Livewire\WithPagination;

class SearchEvent extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $event = Event::where('codigo', 'like', '%' . $this->search . '%')
            ->orWhere('user_id', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.events-packages', [
            'events' => $event,
        ]);
    }
}



