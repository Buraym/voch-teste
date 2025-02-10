<?php

namespace App\Livewire;

use Livewire\Component;

class UpdateEconomicGroup extends Component
{

    public $economicGroup = [];

    public function mount($economicGroup = [])
    {
        $this->economicGroup = $economicGroup;
        
    }
    
    public function render()
    {
        return view('livewire.pages.economic-groups.update-economic-group');
    }
}
