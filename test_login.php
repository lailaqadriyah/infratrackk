<?php
require_once __DIR__.'/vendor/autoload.php';

// Load environment
Dotenv\Dotenv::createImmutable(__DIR__)->load();

// Create the Eloquent capsule
$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => env('DB_HOST', 'localhost'),
    'database'  => env('DB_DATABASE', 'infratrack'),
    'username'  => env('DB_USERNAME', 'root'),
    'password'  => env('DB_PASSWORD', ''),
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Test 1: Check if admin user exists
echo "=== TEST 1: Check Admin User ===\n";
$admin = \Illuminate\Database\Capsule\Manager::table('users')->where('email', 'admin@bappeda.go.id')->first();
if ($admin) {
    echo "Admin User Found:\n";
    echo "- ID: " . $admin->id . "\n";
    echo "- Name: " . $admin->name . "\n";
    echo "- Email: " . $admin->email . "\n";
    echo "- Role ID: " . $admin->role_id . " (Type: " . gettype($admin->role_id) . ")\n";
} else {
    echo "Admin user not found!\n";
}

// Test 2: Check if role with id=1 exists
echo "\n=== TEST 2: Check Role Table ===\n";
$roles = \Illuminate\Database\Capsule\Manager::table('roles')->get();
foreach ($roles as $role) {
    echo "- ID: {$role->id}, Name: {$role->nama_role}\n";
}

echo "\nAll tests completed.\n";
?>

