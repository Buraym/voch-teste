<?php

namespace App\Livewire;

use Livewire\Component;

class ListEconomicGroups extends Component
{

    public $groupsFound = [];
    public $query = "";

    public function mount($groupsFound = [], $query = "")
    {
        $this->groupsFound = $groupsFound;
        $this->query = $query;
    }

    public function render()
    {
        return view('livewire.pages.economic-groups.list-economic-groups');
    }
}
