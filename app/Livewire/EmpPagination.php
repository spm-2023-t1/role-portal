<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employees;
use App\Models\User;

class EmpPagination extends Component
{
     use WithPagination;

     protected $paginationTheme = 'bootstrap';

     public $orderColumn = "name";
     public $sortOrder = "asc";
     public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';

     public $searchTerm = "";

     public function updated(){
          $this->resetPage();
     }

     public function sortOrder($columnName=""){
          $caretOrder = "up";
          if($this->sortOrder == 'asc'){
               $this->sortOrder = 'desc';
               $caretOrder = "down";
          }else{
               $this->sortOrder = 'asc';
               $caretOrder = "up";
          } 
          $this->sortLink = '<i class="sorticon fa-solid fa-caret-'.$caretOrder.'"></i>';

          $this->orderColumn = $columnName;

     }

     public function render(){ 
          $users = User::orderby($this->orderColumn,$this->sortOrder)->select('*');

          if(!empty($this->searchTerm)){

               $users->orWhere('name','like',"%".$this->searchTerm."%");
               $users->orWhere('email','like',"%".$this->searchTerm."%");
          }

          $users = $users->paginate(10);

          return view('livewire.emp-pagination', [
               'users' => $users,
          ]);

     }
}