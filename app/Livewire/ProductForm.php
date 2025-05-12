<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class ProductForm extends Component
{
    public $categories;
    public $message;
    public $name;
    public $price;
    public $product;
    public $description;
    public $alt_text;
    public $keywords;

    public function mount()
    {
        $this->categories = Category::with('children')
            ->doesntHave('children')
            ->get(); // No need to filter categories by brand here

        if ($this->product) {
            $this->name = $this->product->name;
            $this->price = $this->product->price;
            $this->description = $this->product->description;
            $this->alt_text = $this->product->alt_text;
            $this->keywords = explode(',', $this->product->keywords); // Split keywords into an array
        }
    }

    public function render()
    {
        return view('admin.livewire.product-form');
    }
}
