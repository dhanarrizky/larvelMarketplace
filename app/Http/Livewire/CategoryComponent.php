<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
// call product from models for call in the function
use App\Models\Product;
// used pagination
use Livewire\WithPagination;
use Cart;

class CategoryComponent extends Component
{
    use WithPagination;
    public $pageSize = 12;
    public $orderBy = "Default Sorting";
    public $slug;


    public function store($product_id,$product_name,$product_price)
    {
        Cart::add($product_id,$product_name,1,$product_price)->associate('App\Models\Product');
        session()->flash('success_message','Item added in Cart');
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

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        // for get the category
        $category = Category::where('slug',$this->slug)->first();
        $category_id = $category->id;
        $category_name = $category->name;
        // get data from database and give to variable $product
        // $product = Product::paginate(12);
        if( $this->orderBy == 'Price: Low to High')
        {
            $product = Product::where('category_id',$category_id)->orderBy('regular_price','ASC')->paginate($this->pageSize);
        }
        else if( $this->orderBy == 'Price: High to Low' )
        {
            $product = Product::where('category_id',$category_id)->orderBy('regular_price','DESC')->paginate($this->pageSize);
        }
        else if( $this->orderBy == 'Sorting By Newness' )
        {
            $product = Product::where('category_id',$category_id)->orderBy('created_at','DESC')->paginate($this->pageSize);
        }
        else
        {
            $product = Product::where('category_id',$category_id)->paginate($this->pageSize);
        }

        // get chategories from models
        $categories = Category::orderBy('name','ASC')->get();

        return view('livewire.category-component',['products'=>$product,'categories'=>$categories, 'category_name'=>$category_name]);
    }
}
