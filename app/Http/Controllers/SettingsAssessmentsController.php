<?php

namespace App\Http\Controllers;

use App\Models\AssessmentFramework;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class SettingsAssessmentsController extends Controller
{
    //refactor and call it SettingsAssessmentFrameworksController

    public function assessments(){
        $breadcrumbs = [['name' => 'Settings', 'link' => route('settings.general')], ['name' => 'Assessment Management']];
        return view('settings.assessments', compact('breadcrumbs'));
    }

    public function assessmentFrameworksDataTable(){
         $dt = DataTables::of(
            AssessmentFramework::where('company_id', Session::get('company_id'))
        )->addColumn('name', function ($assessmentFramework) {
            return $assessmentFramework->name; // This uses your accessor
        })->addColumn('actions', function ($assessmentFramework) {
            $encryptedId = _encrypt($assessmentFramework->id);
            $editUrl = route('assessment.framework.builder', ['id' => $encryptedId]);
            return view('layout.components.datatable-actions', [
                'editUrl' => $editUrl,
                'deleteClass' => 'delete_assessment_framework',
                'attribute' => 'assessment-framework-id',
                'id' => $encryptedId,
            ])->render();
        })
        ->rawColumns(['actions']) // Allow HTML rendering
        ->make(true);
        return $dt;
    }


    public function createAssessmentFramework(Request $request){
        $validated = $request->validate([
            'name' => 'required|string'
        ], $request->only('name'));
        $validated += ['company_id' => Session::get('company_id'), 'user_id' => Auth::id()];
        AssessmentFramework::create($validated);
        return response()->json(['message' => 'Assessment framework created successfully'], 201);
    }

    public function deleteAssessmentFramework(Request $request){
        $assessmentFrameworkId = $request->get('decrypted_id');
        AssessmentFramework::where('id',  $assessmentFrameworkId)->delete();
    }

}
