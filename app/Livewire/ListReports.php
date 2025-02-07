<?php

namespace App\Livewire;

use Livewire\Component;

class ListReports extends Component
{
    public $reportsFound = [];
    public $query = "";

    public function mount($reportsFound = [], $query = "") {
        $this->reportsFound = $reportsFound;
        $this->query = $query;
    }
    public function render()
    {
        return view('livewire.pages.reports.list-reports');
    }
}
