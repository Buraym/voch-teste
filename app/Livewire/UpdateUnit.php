<?php

namespace App\Livewire;

use Livewire\Component;

class UpdateUnit extends Component
{
    public $unit = [];

    public function mount($unit = []) {
        $this->unit = $unit;
    }

    public function render()
    {
        return view('livewire.pages.units.update-unit');
    }
}
