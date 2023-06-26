<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
// call product from models for call in the function
use App\Models\Product;
// used pagination
use Livewire\WithPagination;
use Cart;

class SearchComponent extends Component
{
    use WithPagination;
    public $pageSize = 12;
    public $orderBy = "Default Sorting";

    public $q;
    public $search_term;

    // public $min_value = 0;
    // public $max_value = 1000;

    public function mount()
    {
        $this->fill(request()->only('q'));
        $this->search_term = '%'.$this->q.'%';
    }


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

    public function render()
    {

        // get data from database and give to variable $product
        // $product = Product::paginate(12);
        if( $this->orderBy == 'Price: Low to High')
        {
            $product = Product::where('name','like',$this->search_term)->orderBy('regular_price','ASC')->paginate($this->pageSize);
        }
        else if( $this->orderBy == 'Price: High to Low' )
        {
            $product = Product::where('name','like',$this->search_term)->orderBy('regular_price','DESC')->paginate($this->pageSize);
        }
        else if( $this->orderBy == 'Sorting By Newness' )
        {
            $product = Product::where('name','like',$this->search_term)->orderBy('created_at','DESC')->paginate($this->pageSize);
        }
        else
        {
            $product = Product::where('name','like',$this->search_term)->paginate($this->pageSize);
        }
        // if( $this->orderBy == 'Price: Low to High')
        // {
        //     // $product = Product::orderBy('regular_price','ASC')->paginate($this->pageSize);
        //     // filtering max and min value use "whereBetween('regular_price', [$this->min_value,$this->max_value])->"
        //     $product = Product::whereBetween('regular_price', [$this->min_value,$this->max_value])->orderBy('regular_price','ASC')->paginate($this->pageSize);
        // }
        // else if( $this->orderBy == 'Price: High to Low' )
        // {
        //     $product = Product::whereBetween('regular_price', [$this->min_value,$this->max_value])->orderBy('regular_price','DESC')->paginate($this->pageSize);
        // }
        // else if( $this->orderBy == 'Sorting By Newness' )
        // {
        //     $product = Product::whereBetween('regular_price', [$this->min_value,$this->max_value])->orderBy('created_at','DESC')->paginate($this->pageSize);
        // }
        // else
        // {
        //     $product = Product::whereBetween('regular_price', [$this->min_value,$this->max_value])->paginate($this->pageSize);
        // }

        // get chategories from models
        $categories = Category::orderBy('name','ASC')->get();

        return view('livewire.shop-component',['products'=>$product,'categories'=>$categories]);
    }
}
