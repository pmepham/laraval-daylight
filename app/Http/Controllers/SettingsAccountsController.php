<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class SettingsAccountsController extends Controller
{
    //

    public function accounts(){
        $permissionLevels = ['Client', 'Counsellor', 'Admin', 'System Admin'];
        $breadcrumbs = [['name' => 'Settings', 'link' => route('settings.general')], ['name' => 'Account Management']];
        return view('settings.accounts', compact('breadcrumbs', 'permissionLevels'));
    }

    public function accountsDataTable(){
        $dt = DataTables::of(User::query())
        ->addColumn('name', function ($user) {
            return $user->fullname; // This uses your accessor
        })->editColumn('activated_on', function ($user) {
            return $user->created_at?->format('d M Y');
        })->addColumn('actions', function ($user) {
            return view('layout.components.datatable-actions', [
                'editClass' => 'edit_account',
                'deleteClass' => 'delete_account',
                'attribute' => 'user-id',
                'id' => _encrypt($user->id),
            ])->render();
        })
        ->rawColumns(['actions']) // Allow HTML rendering
        ->make(true);
        return $dt;
    }

    public function createAccount(UserRequest $request){
        $validated = $request->validated();
        $validated['company_id'] = 1;
        User::create($validated);
    }

    public function showAccountEditModal(Request $request){
        $user = User::find($request->attributes->get('decrypted_id'), ['id', 'email', 'firstname', 'lastname', 'permission_level'])->toArray();
        $user['id'] = $request->attributes->get('encrypted_id');
        return Response::json($user);
    }

    public function updateAccount(UserRequest $request){
        $validated = $request->validated();
        User::where(['id' => $request->attributes->get('decrypted_id')])->update($validated);
    }

    public function deleteAccount(Request $request){
        User::where(['id' => $request->attributes->get('decrypted_id')])->delete();
        //delete everything else that was associated with this user
    }
}
