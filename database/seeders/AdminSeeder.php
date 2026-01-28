<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('nama_role', 'admin')->first();
        
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@bappeda.go.id',
            'password' => bcrypt('admin123'),
            'email_verified_at' => now(),
            'role_id' => $adminRole?->id ?? 1,
        ]);
    }
}
