<?php

namespace App\Livewire;

use Livewire\Component;

class ListAudits extends Component
{
    public $auditsFound = [];
    public $query = "";

    public function mount($auditsFound = [], $query = "") {
        $this->auditsFound = $auditsFound;
        $this->query = $query;
    }

    public function render()
    {
        return view('livewire.pages.audits.list-audits');
    }
}
