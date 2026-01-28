<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebugController extends Controller
{
    public function checkAuth()
    {
        $user = Auth::user();
        
        return response()->json([
            'authenticated' => Auth::check(),
            'user' => $user ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ] : null,
            'is_admin' => $user && $user->role_id == 1,
        ]);
    }
}
