<?php

namespace App\Livewire;

use Livewire\Component;

class ListEmployees extends Component
{
    public $employeesFound = [];
    public $query = "";
    public function __construct($employeesFound = [], $query = "")
    {
        $this->employeesFound = $employeesFound;
        $this->query = $query;
    }
    public function render()
    {
        return view('livewire.pages.employees.list-employees');
    }
}
