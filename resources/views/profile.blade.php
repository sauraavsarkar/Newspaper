<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="h-8 w-8 rounded-lg bg-indigo-500/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h2 class="font-bold text-2xl tracking-tight text-zinc-900 dark:text-white">
                {{ __('Profile Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 space-y-8">
        <div class="glass-card rounded-[2rem] p-8 relative overflow-hidden">
            <div class="relative z-10 max-w-xl">
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-6">Profile Information</h3>
                <livewire:profile.update-profile-information-form />
            </div>
        </div>

        <div class="glass-card rounded-[2rem] p-8 relative overflow-hidden">
            <div class="relative z-10 max-w-xl">
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-6">Update Password</h3>
                <livewire:profile.update-password-form />
            </div>
        </div>

        <div class="glass-card rounded-[2rem] p-8 relative overflow-hidden border-red-500/20">
            <div class="relative z-10 max-w-xl">
                <h3 class="text-xl font-bold text-red-600 dark:text-red-500 mb-6">Danger Zone</h3>
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</x-app-layout>
