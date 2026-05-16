<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Livewire\WithPagination;

class RoleManager extends Component
{
    use WithPagination;

    public $isModalOpen = false;
    public $editingRoleId = null;
    public $name = '';
    public $selectedPermissions = [];
    public $searchTerm = '';

    public function mount()
    {
        if (!auth()->user()->can('assign roles')) {
            abort(403);
        }
    }

    public $permissionGroups = [
        'Articles' => ['create article', 'edit own article', 'edit any article', 'delete article'],
        'Publishing' => ['publish article', 'approve article', 'reject article', 'toggle breaking news'],
        'Content' => ['manage categories', 'upload media'],
        'Users & Roles' => ['manage users', 'assign roles'],
        'System' => ['manage homepage', 'manage ads', 'manage subscriptions', 'view analytics', 'moderate comments', 'view logs', 'send alerts'],
    ];

    public function syncAll()
    {
        if (!auth()->user()->can('assign roles')) {
            abort(403);
        }

        try {
            \Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--class' => 'RolesAndPermissionsSeeder',
                '--force' => true
            ]);
            session()->flash('message', 'System Matrix synchronized successfully from master configuration.');
        } catch (\Exception $e) {
            session()->flash('error', 'Sync failed: ' . $e->getMessage());
        }
    }

    protected $rules = [
        'name' => 'required|string|unique:roles,name',
    ];

    public function create()
    {
        $this->reset(['editingRoleId', 'name', 'selectedPermissions']);
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $role = Role::findById($id);
        $this->editingRoleId = $id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|unique:roles,name,' . $this->editingRoleId,
        ]);

        if ($this->editingRoleId) {
            $role = Role::findById($this->editingRoleId);
            $role->update(['name' => $this->name]);
        } else {
            $role = Role::create(['name' => $this->name]);
        }

        $role->syncPermissions($this->selectedPermissions);

        $this->isModalOpen = false;
        $this->reset(['editingRoleId', 'name', 'selectedPermissions']);
        
        session()->flash('message', 'Role updated successfully.');
    }

    public function delete($id)
    {
        $role = Role::findById($id);
        if ($role->name === 'Admin') {
            session()->flash('error', 'Cannot delete Admin role.');
            return;
        }
        $role->delete();
        session()->flash('message', 'Role deleted successfully.');
    }

    public function render()
    {
        $roles = Role::where('name', 'like', '%' . $this->searchTerm . '%')
            ->with('permissions')
            ->paginate(10);

        return view('livewire.admin.role-manager', [
            'roles' => $roles,
            'allPermissions' => Permission::all(),
        ])->layout('layouts.app');
    }
}
