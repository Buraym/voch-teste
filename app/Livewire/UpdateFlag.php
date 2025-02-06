<?php

namespace App\Livewire;

use Livewire\Component;

class UpdateFlag extends Component
{

    public $flag = [];

    public function mount($flag = [])
    {
        $this->flag = $flag;
        
    }

    public function render()
    {
        return view('livewire.pages.flags.update-flag');
    }
}
