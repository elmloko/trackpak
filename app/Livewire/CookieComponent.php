<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cookie;

class CookieComponent extends Component
{
    public $showBar = false;

    public function render()
    {
        $this->es_aceptada();
        
        return view('livewire.cookie-component');
    }

    public function es_aceptada()
    {
        if (Cookie::has('name_cookie')) {
            $this->showBar = false;
        }
    }

    public function aceptarCookie()
    {
        Cookie::queue('name_cookie', 'Aceptada');
        $this->showBar = false;
    }
}