<?php

namespace App\Livewire;

use Livewire\Component;

class UpdateEmployee extends Component
{
    public $employee = [];

    public function mount($employee = []) {
        $this->$employee = $employee;
    }

    public function render()
    {
        return view('livewire.pages.employees.update-employee');
    }
}
