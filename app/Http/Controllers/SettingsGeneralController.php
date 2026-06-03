<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingsGeneralController extends Controller
{
    //
    public function general(){
        $company = Company::where('id', '=', Session::get('company_id'))->first();
        $breadcrumbs = [['name' => 'Settings', 'link' => route('settings.general')], ['name' => 'General Settings']];
        return view('settings.general', compact(['company', 'breadcrumbs']));
    }

    public function updateSingleColumn(Request $request){
        Company::where('id' , '=', Session::get('company_id'))->update([$request->input('name') => $request->input('value')]);
    }

    //also make a company history table
    
}
