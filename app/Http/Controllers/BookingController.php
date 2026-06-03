<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    public function index(){
        $breadcrumbs = [['name' => 'Bookings']];
        return view('booking.booking', compact('breadcrumbs'));
    }

}
