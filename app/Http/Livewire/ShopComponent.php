<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
// call product from models for call in the function
use App\Models\Product;
// used pagination
use Livewire\WithPagination;
use Cart;

class ShopComponent extends Component
{
    use WithPagination;
    public $pageSize = 12;
    public $orderBy = "Default Sorting";


    // decralation value of price parameter
    public $min_value = 0;
    public $max_value = 1000;


    public function store($product_id,$product_name,$product_price)
    {
        Cart::instance('cart')->add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');
        session()->flash('success_message','Item added in Cart');
        $this->emitTo('cart-icon-component','refreshComponent');
        return redirect()->route('shop.cart');
    }

    public function changePageSize($size)
    {
        $this->pageSize = $size;
    }

    public function changeOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    //tambah love
    public function addToWishlist($product_id,$product_name,$product_price)
    {
        Cart::instance('wishlist')->add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');
        //refrashcomponent from refrash in cart icon component
        $this->emitTo('wishlist-icon-component', 'refreshComponent');
    }

    // remove wishlist
    public function removeFromWishlist($product_id)
    {
        foreach (Cart::instance('wishlist')->content() as $witem) {
            if($witem->id==$product_id)
            {
                Cart::instance('wishlist')->remove($witem->rowId);
                $this->emitTo('wishlist-icon-component','refreshComponent');
                return;
            }
        }
    }

    public function render()
    {

        // get data from database and give to variable $product
        // $product = Product::paginate(12);
        if( $this->orderBy == 'Price: Low to High')
        {
            // $product = Product::orderBy('regular_price','ASC')->paginate($this->pageSize);
            // filtering max and min value use "whereBetween('regular_price', [$this->min_value,$this->max_value])->"
            $product = Product::whereBetween('regular_price', [$this->min_value,$this->max_value])->orderBy('regular_price','ASC')->paginate($this->pageSize);
        }
        else if( $this->orderBy == 'Price: High to Low' )
        {
            $product = Product::whereBetween('regular_price', [$this->min_value,$this->max_value])->orderBy('regular_price','DESC')->paginate($this->pageSize);
        }
        else if( $this->orderBy == 'Sorting By Newness' )
        {
            $product = Product::whereBetween('regular_price', [$this->min_value,$this->max_value])->orderBy('created_at','DESC')->paginate($this->pageSize);
        }
        else
        {
            $product = Product::whereBetween('regular_price', [$this->min_value,$this->max_value])->paginate($this->pageSize);
        }

        // get chategories from models
        $categories = Category::orderBy('name','ASC')->get();

        return view('livewire.shop-component',['products'=>$product,'categories'=>$categories]);
    }
}
