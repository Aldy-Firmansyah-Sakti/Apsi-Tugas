<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// Debug route - remove in production
Route::get('/debug/admin-test', function () {
    $user = User::where('email', 'admin@cafex.com')->first();
    
    if (!$user) {
        return response()->json(['error' => 'User not found']);
    }
    
    return response()->json([
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
        ],
        'password_checks' => [
            'admin123' => Hash::check('admin123', $user->password),
            'password' => Hash::check('password', $user->password),
        ],
        'auth_status' => Auth::check(),
        'current_user' => Auth::user() ? Auth::user()->email : null,
    ]);
});

Route::post('/debug/admin-login', function () {
    $credentials = [
        'email' => 'admin@cafex.com',
        'password' => 'admin123'
    ];
    
    $user = User::where('email', $credentials['email'])->first();
    
    if (!$user) {
        return response()->json(['error' => 'User not found']);
    }
    
    if ($user->role !== 'admin') {
        return response()->json(['error' => 'Not admin role']);
    }
    
    if (!Hash::check($credentials['password'], $user->password)) {
        return response()->json(['error' => 'Password mismatch']);
    }
    
    $loginResult = Auth::attempt($credentials);
    
    return response()->json([
        'login_attempt' => $loginResult,
        'auth_check' => Auth::check(),
        'current_user' => Auth::user() ? Auth::user()->email : null,
    ]);
});