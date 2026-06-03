<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class UserService
{
    
    public function login(LoginRequest $loginRequest){
        $validated = $loginRequest->validated();
        $email = $validated['email'];
        $password = $validated['password'];
        return $this->createSession($email, $password);
    }

    public function register(RegisterRequest $registerRequest){
        $validated = $registerRequest->validated();
        $email = $validated['email'];
        $password = $validated['password'];
        $validated['password'] = Hash::make($password);
        $validated['company_id'] = 1;
        User::create($validated);
        return $this->createSession($email, $password);
    }

    private function createSession(String $email, String $password){
        if(Auth::attempt(['email' => $email, 'password' => $password])){
            $user = Auth::user();
            //add more settings data to the session
            Session::put('company_id', $user->company_id);
            return Response::json(['redirect' => route('dashboard')]);
        }
        return Response::json(['error' => 'Invalid email or password'], 422);
        
    }

    public function logout(){
        Auth::logout();
        Session::remove('comapny_id');
        return Response::json(['redirect' => route('login')]);
    }

}
