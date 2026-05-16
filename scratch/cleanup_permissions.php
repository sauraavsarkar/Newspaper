<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$masterPermissions = [
    'create article', 'edit own article', 'edit any article', 'delete article',
    'publish article', 'approve article', 'reject article', 'toggle breaking news',
    'manage categories', 'upload media', 'manage users', 'assign roles',
    'manage homepage', 'manage ads', 'manage subscriptions', 'view analytics',
    'moderate comments', 'view logs', 'send alerts'
];

echo "Cleaning up permissions...\n";

// Create master permissions if they don't exist
foreach ($masterPermissions as $name) {
    Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
}

// Delete permissions not in master list (or rename them?)
$allPermissions = Permission::all();
foreach ($allPermissions as $permission) {
    if (!in_array($permission->name, $masterPermissions)) {
        echo "Removing obsolete permission: {$permission->name}\n";
        $permission->delete();
    }
}

echo "Done cleaning up permissions.\n";

// Reset Admin role to have all permissions
$admin = Role::where('name', 'Admin')->first();
if ($admin) {
    $admin->syncPermissions(Permission::all());
    echo "Admin permissions synchronized.\n";
}
