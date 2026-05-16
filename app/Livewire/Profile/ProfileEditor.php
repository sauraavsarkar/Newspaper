<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Password;

class ProfileEditor extends Component
{
    use WithFileUploads;

    public User $user;
    public $avatar;
    public $name;
    public $username;
    public $email;
    public $bio;
    public $location;
    public $website;
    public $twitter_url;
    public $linkedin_url;
    public $phone;
    public $beat;
    public $byline;
    public $status;
    public $selectedRole;
    public $two_factor_enabled;

    public $isAdminView = false;

    public function mount(User $user = null)
    {
        $this->user = $user ?? auth()->user();
        
        // Authorization
        if (auth()->user()->id !== $this->user->id && !auth()->user()->hasRole('Admin')) {
            abort(403);
        }

        $this->isAdminView = auth()->user()->hasRole('Admin');

        $this->name = $this->user->name;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->bio = $this->user->bio;
        $this->location = $this->user->location;
        $this->website = $this->user->website;
        $this->twitter_url = $this->user->twitter_url;
        $this->linkedin_url = $this->user->linkedin_url;
        $this->phone = $this->user->phone;
        $this->beat = $this->user->beat;
        $this->byline = $this->user->byline;
        $this->status = $this->user->status;
        $this->two_factor_enabled = $this->user->two_factor_enabled;
        $this->selectedRole = $this->user->roles->first()?->name;
    }

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:100|unique:users,username,' . $this->user->id,
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'avatar' => 'nullable|image|max:1024', // 1MB Max
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
        ];

        if ($this->isAdminView) {
            $rules['beat'] = 'nullable|string|max:255';
            $rules['byline'] = 'nullable|string|max:255';
            $rules['status'] = 'required|in:active,suspended,banned';
            $rules['selectedRole'] = 'required|exists:roles,name';
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'bio' => $this->bio,
            'location' => $this->location,
            'website' => $this->website,
            'twitter_url' => $this->twitter_url,
            'linkedin_url' => $this->linkedin_url,
            'phone' => $this->phone,
        ];

        if ($this->isAdminView) {
            $data['beat'] = $this->beat;
            $data['byline'] = $this->byline;
            $data['status'] = $this->status;
            
            // Role assignment
            $this->user->syncRoles([$this->selectedRole]);
        }

        if ($this->avatar) {
            // Delete old avatar if exists
            if ($this->user->avatar) {
                Storage::disk('public')->delete($this->user->avatar);
            }
            $data['avatar'] = $this->avatar->store('avatars', 'public');
        }

        $this->user->update($data);
        
        $this->avatar = null;

        session()->flash('message', 'Profile updated successfully.');
    }

    public function sendResetLink()
    {
        if (!$this->isAdminView) return;

        Password::sendResetLink(['email' => $this->user->email]);
        session()->flash('message', 'Password reset link sent to ' . $this->user->email);
    }

    public function revokeTwoFactor()
    {
        if (!$this->isAdminView) return;

        $this->user->update(['two_factor_enabled' => false]);
        $this->two_factor_enabled = false;
        session()->flash('message', '2FA has been revoked for this user.');
    }

    public function render()
    {
        return view('livewire.profile.profile-editor', [
            'roles' => Role::all(),
            'articleCount' => $this->user->articles()->count(),
            'totalViews' => $this->user->articles()->withCount('views')->get()->sum('views_count'),
        ])->layout('layouts.app');
    }
}
