<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\UserService;

class LoginController extends Controller
{
    public UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    //
    public function index(){
        return view('auth.login');
    }

    public function authenticate(LoginRequest $loginRequest){
        return $this->userService->login($loginRequest);
    }

    public function logout(){
        $this->userService->logout();
        return redirect()->route('login');
    }


}
