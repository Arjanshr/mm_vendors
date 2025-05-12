<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class ExpenseForm extends Component
{
    public $users;
    public $categories;
    public $expense;
    public $user;
    public $user_id;
    public $user_name;
    public $read_only;


    public function mount()
    {
        $this->users = User::get();
        if ($this->expense) {
            $this->user_id = $this->expense->user_id ?? 0;
            $this->user_name = $this->expense->user_id ? $this->expense->user->name : $this->expense->name;
        }
    }

    public function render()
    {
        return view('livewire.expense-form');
    }

    public function updatedUserId($value)
    {
        if ($value){
            $this->user_name = User::find($value)->name;
            $this->read_only = true;
        }else{
            $this->user_name = '';
            $this->read_only = false;
        }
    }
}
