<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class Actions extends Component
{
    public mixed $item;

    public function render(): View
    {
        return view('livewire.actions');
    }
}
