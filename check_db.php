<?php
// Load Laravel
define('LARAVEL_START', microtime(true));
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Get database connection
use Illuminate\Support\Facades\DB;

// Check roles
echo "=== ROLES TABLE ===\n";
$roles = DB::table('role')->get();
foreach ($roles as $role) {
    echo "ID: {$role->id}, Name: {$role->nama_role}\n";
}

echo "\n=== USERS TABLE ===\n";
$users = DB::table('users')->get();
foreach ($users as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role ID: {$user->role_id}\n";
}
