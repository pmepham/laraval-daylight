@php 
    $encFrameworkId = $assessment_framework['encrypted_id'];
    $encQuestionId = $assessment_framework_question['encrypted_id'];
    $questionForId = 'question_'.$encQuestionId;

@endphp
<div id="assessment_framework_question_{{ $encQuestionId }}" class="m-0">
    <div class="bg-hover-light mx-n5 px-5">
        <div class="d-flex align-items-center collapsible py-3 toggle mb-0 active ps-5 mx-n5" data-bs-toggle="collapse" data-bs-target="#{{ $questionForId }}" aria-expanded="true">
            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                <i class="ki-solid ki-minus-square toggle-on text-primary fs-1"></i>
                <i class="ki-solid ki-plus-square toggle-off fs-1"></i>
            </div>
            <h4 class="text-gray-700 fw-bold cursor-pointer mb-0 d-flex justify-content-between">{{ $assessment_framework_question['name'] }}</h4>
            
        </div>
        <div id="{{ $questionForId }}" class="fs-6 ms-1 collapse show" style="">
            <div class="text-gray-600 fw-semibold fs-6 ps-10">
                @foreach ($assessment_framework_options as $assessment_framework_option)
                @php
                    $encOptionId = $assessment_framework_option['encrypted_id'];
                    $optionForId = 'option_'.$encQuestionId.'_'.$encOptionId;
                    $optionName = 'question['.$encQuestionId.']['.$encOptionId.']';
                    $answer = $assessment_answers[$assessment_framework_option['id']] ?? false;
                    $answer = !empty($answer) ? $answer : '';
                @endphp
                <div class="d-flex flex-column pb-5">
                    <label for="{{ $optionForId }}">{{ $assessment_framework_option['name'] }}</label>
                    <textarea id="{{ $optionForId }}" class="form-control" name="{{ $optionName }}">{{ $answer }}</textarea>
                </div>
                @endforeach
            </div>
            <div class="d-flex flex-stack pb-5">
                <button class="btn btn-sm btn-primary edit_assessment_framework_question" data-assessment-framework-question-id="{{ $encQuestionId }}">Edit Question</button>
                <button class="btn btn-sm btn-danger delete_assessment_framework_question"  data-assessment-framework-question-id="{{ $encQuestionId }}">Delete Question</button>
            </div>
        </div>
    </div>
</div>