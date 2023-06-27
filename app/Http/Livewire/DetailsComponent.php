<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Database\Factories\ProductFactory;
use Livewire\Component;
use Cart;

class DetailsComponent extends Component
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function store($product_id,$product_name,$product_price)
    {
        Cart::instance('cart')->add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');
        session()->flash('success_message','Item added in Cart');
        $this->emitTo('cart-icon-component','refreshComponent');
        return redirect()->route('shop.cart');
    }

    public function render()
    {
        // for get detail product from slug
        $product = Product::where('slug', $this->slug)->first();
        // for get random recomendation
        $rproducts = Product::where('category_id', $product->category_id)->inRandomOrder()->limit(4)->get();
        // for get new product from lastes update product post
        $nproducts = Product::Latest()->take(4)->get();
        return view('livewire.details-component',['product'=>$product,'rproducts'=>$rproducts,'nproducts'=>$nproducts]);
    }
}
