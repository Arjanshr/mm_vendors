<?php

namespace App\Livewire;

use App\Enums\CategoryType;
use App\Models\Category;
use Livewire\Component;

class CategoryForm extends Component
{
    public $category;
    public $parent_categories;
    public $types;
    public $type;
    public string $category_type;
    public $message;
    public bool $type_disabled = false;

    public function mount()
    {
        if ($this->category) {
            if (!$this->validateCategory($this->category) || $this->category->checkIfHasItems()) {
                $this->type_disabled = true;
            }
            $children = $this->category->getAllChildrenIds();
            $this->parent_categories = Category::where('status', 1)
                ->where('id', '!=', $this->category->id)
                ->where('parent_id',null)
                ->whereNotIn('id', $children)
                ->get();

            $this->category_type = strtolower($this->category->type);
            if (!$this->validateCategory($this->category)) $this->type_disabled = true;
        } else {
            $this->parent_categories = Category::where('status', 1)
            ->where('parent_id',null)
            ->get();
        }
    }

    public function render()
    {
        return view('admin.livewire.category-form');
    }


    private function validateCategory($category)
    {
        if ($category->parent_id != 0 || $category->id == 1 || $category->id == 2 || $category->id == 3) return false;
        return true;
    }

    private function validateCategoryMessage($category, $value): string
    {
        if ($category->parent_id != 0) return 'Cannot change the type if the category has a parent category';
        return 'Type of all the child categories of this category will change to ' . $value;
    }
}
