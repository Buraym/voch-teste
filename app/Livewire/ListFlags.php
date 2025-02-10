<?php

namespace App\Livewire;

use Livewire\Component;

class ListFlags extends Component
{
    public $flagsFound = [];
    public $query = "";

    public function mount($flagsFound = [], $query = "")
    {
        $this->flagsFound = $flagsFound;
        $this->query = $query;
    }

    public function render()
    {
        return view('livewire.pages.flags.list-flags');
    }
}
