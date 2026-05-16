<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class UserManager extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public function mount()
    {
        if (!auth()->user()->can('assign roles')) {
            abort(403);
        }
    }

    public function render()
    {
        $users = User::with('roles')
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            })
            ->paginate(10);

        return view('livewire.admin.users.user-manager', [
            'users' => $users,
            'roles' => Role::all(),
        ]);
    }
}
