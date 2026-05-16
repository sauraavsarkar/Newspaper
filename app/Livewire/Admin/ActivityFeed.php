<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ActivityFeed extends Component
{
    use WithPagination;

    public $role = '';
    public $actionType = '';
    public $search = '';
    public $dateFrom = '';
    public $dateTo = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingRole() { $this->resetPage(); }
    public function updatingActionType() { $this->resetPage(); }

    public function render()
    {
        $query = ActivityLog::with(['causer', 'subject'])
            ->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                  ->orWhere('properties', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->role) {
            $query->whereHas('causer', function($q) {
                $q->role($this->role);
            });
        }

        if ($this->actionType) {
            $query->where('log_name', $this->actionType);
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        return view('livewire.admin.activity-feed', [
            'activities' => $query->paginate(20),
            'actionTypes' => ActivityLog::select('log_name')->distinct()->pluck('log_name')->filter(),
            'roles' => \Spatie\Permission\Models\Role::pluck('name'),
        ]);
    }
}
