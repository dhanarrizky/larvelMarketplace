<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AdminAddCategoryComponent extends Component
{
    use WithFileUploads;

    public $name;
    public $slug;

    public $image;
    public $is_popular;

    // for generate slug (or create slug by name)
    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    // for validation input
    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name'=>'required',
            'slug'=>'required',
            'image'=>'required'
        ]);
    }

    public function storeCategory()
    {
        $this->validate([
            'name'=>'required',
            'slug'=>'required',
            'image'=>'required'
        ]);
        $category = new Category();
        $category->name = $this->name;
        $category->slug = $this->slug;
        $imageName = Carbon::now()->timestamp.'.'.$this->image->extension();
        $this->image->storeAs('categories',$imageName);
        $category->image = $imageName;
        $category->is_popular = $this->is_popular;
        $category->save();
        session()->flash('message','Category has been created successfully!');
    }

    public function render()
    {
        return view('livewire.admin.admin-add-category-component');
    }
}
