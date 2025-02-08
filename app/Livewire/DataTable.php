<?php

namespace App\Livewire;

use Livewire\Component;

class DataTable extends Component
{
    public $columns = [];
    public $rows = [];
    public $link = "";
    public $downloadRoute = "";
    public $deleteLink = "";

    public function mount($columns = [], $rows = [], $link = "", $downloadRoute = "", $deleteLink = "")
    {
        $this->columns = $columns;
        $this->rows = $rows;
        $this->link = $link;
        $this->downloadRoute = $downloadRoute;
        $this->deleteLink = $deleteLink;
        
    }

    public function render()
    {
        return view('livewire.components.data-table');
    }
}
