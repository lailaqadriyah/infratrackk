<?php
require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = \App\Models\User::where('email', 'admin@bappeda.go.id')->first();

if ($user) {
    echo "User: " . $user->name . "\n";
    echo "Role ID: " . $user->role_id . "\n";
    echo "Is Admin: " . ($user->isAdmin() ? 'YES' : 'NO') . "\n";
} else {
    echo "User not found\n";
}
