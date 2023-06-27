<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\HomeSlider;

class AdminHomeSliderComponent extends Component
{
    public $slider_id;

    public function deleteSlide()
    {
        $slide =HomeSlider::find($this->slider_id);
        unlink('assets/imgs/slider/'.$slide->image);
        $slide->delete();
        session()->flash('message','Slide has been deleted!');
    }

    public function render()
    {
        $slide = HomeSlider::orderBy('created_at','DESC')->get();
        return view('livewire.admin.admin-home-slider-component',['slider'=>$slide]);
    }
}
