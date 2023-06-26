<?php

namespace App\Http\Livewire;

use Livewire\Component;

class WishlistIconComponent extends Component
{
    public $listeners = ['refreshComponent'=>'$refresh'];
    public function render()
    {
        return view('livewire.wishlist-icon-component');
    }
}
