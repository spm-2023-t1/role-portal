<?php

namespace App\Livewire;

use App\Models\Skill;
use App\Models\User;
use Livewire\Component;

class SearchUser extends Component
{
    public $search = '';
    
    public function render()
    {
        return view('livewire.search-user', [
            'users' => User::whereLike('name', $this->search ?? ''),
            // 'skills' => Skill::where()
        ]);
    }
}
