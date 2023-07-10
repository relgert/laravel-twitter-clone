<?php

namespace App\Http\Livewire;


use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Counter extends Component
{


    public $count = 0;
    public $name = 'test';

    public function increment()
    {
        if(Auth::user()){
            $this->count++;
        }else{
            $this->count--;
        }

    }

    public function changeName(){
        $this->name = 'reg';
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
