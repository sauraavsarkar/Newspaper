<?php

namespace App\Livewire\Reader;

use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.public')]
class AccountActivity extends Component
{
    use WithPagination;

    public function render()
    {
        $activities = ActivityLog::forUser(Auth::user())
            ->with(['subject'])
            ->latest()
            ->paginate(15);

        return view('livewire.reader.account-activity', [
            'activities' => $activities,
        ]);
    }
}
