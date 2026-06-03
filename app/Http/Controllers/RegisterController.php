<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }
    
    public function index(){
        return view('auth.register');
    }

    public function authenticate(RegisterRequest $registerRequest){
        $validated = $registerRequest->validated();
        return $this->authService->register($validated);
    }
}
