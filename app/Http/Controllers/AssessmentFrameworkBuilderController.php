<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssessmentFrameworkQuestionRequest;
use App\Models\AssessmentFramework;
use App\Models\AssessmentFrameworkOption;
use App\Models\AssessmentFrameworkQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AssessmentFrameworkBuilderController extends Controller
{

    public $questionTypes = [
        'freetext' => 'Freetext', 
        'single-option' => 'Single Option', 
        'multiple-option' => 'Multiple Option'
    ];
     
    //
    public function assessmentFrameworkBuilder(Request $request){
        $assessmentFrameworkId = $request->get('decrypted_id');
        $assessmentFramework = AssessmentFramework::find($assessmentFrameworkId)->toArray();
        $assessmentFrameworkQuestions = AssessmentFrameworkQuestion::where('assessment_framework_id', $assessmentFrameworkId)->orderBy('id')->get()->toArray();
        $assessmentFrameworkOptions = collect(AssessmentFrameworkOption::where('assessment_framework_id', $assessmentFrameworkId)->get())->groupBy('assessment_framework_question_id')->toArray();
        //_log($assessmentFramework, $assessmentFrameworkQuestions, $assessmentFrameworkOptions);
        $breadcrumbs = [['name' => 'Assessment Management'], ['name' => 'Assessment Builder'], ['name' => $assessmentFramework['name']]];
        return view('assessment-framework.assessment-builder', [
            'breadcrumbs' => $breadcrumbs, 
            'assessment_framework' => $assessmentFramework, 
            'assessment_framework_questions' => $assessmentFrameworkQuestions, 
            'assessment_framework_options' => $assessmentFrameworkOptions,
            'question_types' => $this->questionTypes
        ]);
    }

    //creates a question with options and returns the html
    public function createAssessmentFrameworkQuestion(AssessmentFrameworkQuestionRequest $request){
        $assessmentFrameworkId = (int) $request->get('decrypted_id');
        $validated = $request->validated();
        $validated['company_id'] = 1; // Hardcoded for now, adjust as needed
        $validated['user_id'] = auth()->id();
        $validated['assessment_framework_id'] = $assessmentFrameworkId;
        //create a new question for this framework
        $assessmentFrameworkQuestion = AssessmentFrameworkQuestion::create($validated);
        $assessmentFrameworkQuestionId = $assessmentFrameworkQuestion->id;
        // Create associated options // could change this to insert a bulk of options reduce queries
        foreach ($validated['question_options'] as $option) {
            AssessmentFrameworkOption::create([
                'company_id' => $validated['company_id'],
                'user_id' => auth()->id(),
                'assessment_framework_id' => $assessmentFrameworkId,
                'assessment_framework_question_id' => $assessmentFrameworkQuestionId,
                'name' => $option['name'],
                'weight' => 0
            ]);
        }

        //fetch all the options and key
        $assessmentFrameworkOptions = AssessmentFrameworkOption::
            where('assessment_framework_id', $assessmentFrameworkId)
            ->where('assessment_framework_question_id', $assessmentFrameworkQuestionId)
            ->get();

        $html = view('assessment-framework.components.question-' . $assessmentFrameworkQuestion['question_type'], [
                            'assessment_framework' => ['encrypted_id' => $request->get('encrypted_id')],
                            'assessment_framework_question' => $assessmentFrameworkQuestion,
                            'assessment_framework_options' => $assessmentFrameworkOptions ?? []])->render();
        return response()->json(['html' => $html], 201);
    }

    public function deleteAssessmentFrameworkQuestion(Request $request){
        $validated = $request->validate(['assessment_framework_question_id' => 'required']);
        $assessmentFrameworkQuestionId = _decrypt($validated['assessment_framework_question_id']);
        _log($validated, $assessmentFrameworkQuestionId);
        $del = AssessmentFrameworkQuestion::where('id', $assessmentFrameworkQuestionId)->delete();
        _log($del);
        AssessmentFrameworkOption::where('assessment_framework_question_id', $assessmentFrameworkQuestionId)->delete();
        return response()->json('Question succesfully deleted', 201);
    }

    public function editAssessmentFrameworkQuestion(Request $request){
        //return the data for for the question along with the options
        $assessmentFrameworkQuestionId = $request->get('decrypted_id');
        $assessmentFrameworkQuestion = AssessmentFrameworkQuestion::where('id', $assessmentFrameworkQuestionId)->orderBy('id')->get()->toArray();
        $assessmentFrameworkOptions = collect(AssessmentFrameworkOption::where('assessment_framework_question_id', $assessmentFrameworkQuestionId)->get())->groupBy('assessment_framework_question_id')->toArray();
        return response()->json(['question' => $assessmentFrameworkQuestion, 'options' => $assessmentFrameworkOptions], 200);
    }

    public function updateAssessmentFrameworkQuestion(){

    }
}
