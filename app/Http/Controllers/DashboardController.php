<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function index(){
        //Auth::logout();
        $breadcrumbs = [['name' => 'Dashboard']];
        return view('dashboard.dashboard', compact('breadcrumbs'));
    }

}
