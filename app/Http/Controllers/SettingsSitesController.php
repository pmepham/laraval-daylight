<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteRequest;
use App\Http\Requests\UserRequest;
use App\Models\Room;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class SettingsSitesController extends Controller
{

    public function sites(){
        $permissionLevels = ['Client', 'Counsellor', 'Admin', 'System Admin'];
        $breadcrumbs = [['name' => 'Settings', 'link' => route('settings.general')], ['name' => 'Site Management']];
        return view('settings.sites', compact('breadcrumbs', 'permissionLevels'));
    }

    public function sitesDataTable(){
        $dt = DataTables::of(
            Site::with('rooms')->where('company_id', Session::get('company_id'))
        )->addColumn('name', function ($site) {
            return $site->name; // This uses your accessor
        })->addColumn('rooms', function ($site) {
            return $site->rooms->pluck('name')->implode(', ');
        })->addColumn('actions', function ($site) {
            return view('layout.components.datatable-actions', [
                'editClass' => 'edit_site',
                'deleteClass' => 'delete_site',
                'attribute' => 'site-id',
                'id' => _encrypt($site->id),
            ])->render();
        })
        ->rawColumns(['actions']) // Allow HTML rendering
        ->make(true);
        return $dt;
    }

    public function createSite(SiteRequest $request){
        $validated = $request->validated();
        $validated['company_id'] = 1; // Hardcoded for now, adjust as needed
        // Create the Site
        $site = Site::create($validated);

        // Create associated Rooms
        foreach ($validated['site_rooms'] as $room) {
            Room::create([
                'name' => $room['name'],
                'site_id' => $site->id,
                'company_id' => $validated['company_id'],
            ]);
        }

        return response()->json(['message' => 'Site and rooms created successfully'], 201);
    }

    public function showSiteEditModal(Request $request){
        $siteId = $request->get('decrypted_id');
        $site = Site::select(['id', 'name', 'address_line_1', 'address_line_2', 'address_line_3', 'address_line_4', 'post_code'])
            ->where('id', '=', $siteId)->get()->first()->toArray();
        $rooms = Room::select(['id', 'name'])
            ->where('site_id', '=', $siteId)->orderBy('id', 'asc')->get()->toArray();
        return Response::json(['site' => $site, 'rooms' => $rooms]);
    }

    public function updateSite(SiteRequest $request){
        $siteId = $request->get('decrypted_id');
        $validated = $request->validated();
        $validated['company_id'] = 1; // Hardcoded for now, adjust as needed
        Site::find($siteId)->update($validated);
        //delete all rooms
        Room::where('site_id', '=', $siteId)->delete();
        //re-insert rooms again but this time give the id
        foreach ($validated['site_rooms'] as $room) {
            $roomId = !empty($room['id']) ? _decrypt($room['id']) : null;
            Room::create([
                'id' => $roomId,
                'name' => $room['name'],
                'site_id' => $siteId,
                'company_id' => $validated['company_id'],
            ]);
        }
        return response()->json(['message' => 'Site and rooms updated successfully'], 201);
    }

    public function deleteSite(Request $request){
        $siteId = $request->get('decrypted_id');
        Site::where('id', '=', $siteId)->delete();
        Room::where('site_id', '=', $siteId)->delete();
    }
}
