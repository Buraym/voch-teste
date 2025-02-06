<?php

namespace App\Livewire;

use Livewire\Component;

class ListUnits extends Component
{
    public $unitsFound = [];
    public $query = "";

    public function mount($unitsFound = [], $query = "")
    {
        $this->unitsFound = $unitsFound;
        $this->query = $query;
    }

    public function render()
    {
        return view('livewire.pages.units.list-units');
    }
}
