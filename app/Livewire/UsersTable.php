<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UsersTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $loading = false;
    public $error = null;
    public $success = null;

    protected $queryString = ['search', 'sortBy', 'sortDirection'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $this->loading = true;
        try {
            $users = User::query()
                ->when($this->search, function($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                          ->orWhere('email', 'like', '%'.$this->search.'%');
                })
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate(10);
            $this->error = null;
        } catch (\Exception $e) {
            $this->error = 'An error occurred while fetching users.';
            $users = collect([]);
        }
        $this->loading = false;
        return view('livewire.users-table', compact('users'));
    }
}

