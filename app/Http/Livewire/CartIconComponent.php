<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CartIconComponent extends Component
{
    public $listeners = ['refreshComponent'=>'$refresh'];
    public function render()
    {
        return view('livewire.cart-icon-component');
    }
}
