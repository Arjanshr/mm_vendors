<?php

namespace App\Livewire;

use Livewire\Component;

class BrandForm extends Component
{
    public $message;
    public $brand;

    public function mount()
    {
        
    }

    public function render()
    {
        return view('admin.livewire.brand-form');
    }
}
