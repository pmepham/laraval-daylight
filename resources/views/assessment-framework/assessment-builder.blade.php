@extends('layout.main')

@section('css')

@endsection

@section('title')
    Assessment Builder
@endsection


@section('breadcrumbs')
    <x-breadcrumbs :items="$breadcrumbs"></x-breadcrumbs>
@endsection

@section('content')

    <div class="col col-md-6 mx-auto">
        <div class="d-flex flex-stack mb-5">
            <a class="btn btn-sm btn-secondary" href="{{ route('settings.assessments') }}">Back</a>
            <button class="btn btn-sm btn-primary create_assessment_framework_question"
                data-assessment-framework-id="<?= $assessment_framework['encrypted_id']?>">Add a Question</button>
        </div>

        <div class="card mb-0">
            <div class="card-header">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ $assessment_framework['name'] }} </h3>
                </div>
            </div>
            <div id="assessment_framework_content" class="card-body p-5 py-0">
                <form class="mb-0">
                    <div id="no_questions" style="@if(!empty($assessment_framework_questions)) display:none; @endif">
                        <div class="alert alert-primary d-flex align-items-center p-5 my-5">
                            <i class="ki-solid ki-shield-tick fs-2hx text-primary me-4"></i>
                            <div class="d-flex flex-column">
                                <h4 class="mb-1 text-primary">No Questions</h4>
                                <span>You currently don't have any questions for this assessment framework.</span>
                            </div>
                        </div>
                    </div>
                    @foreach ($assessment_framework_questions as $key => $assessment_framework_question)
                        @include('assessment-framework.components.question-' . $assessment_framework_question['question_type'], [
                            'assessment_framework' => $assessment_framework,
                            'assessment_framework_question' => $assessment_framework_question,
                            'assessment_framework_options' => $assessment_framework_options[$assessment_framework_question['id']] ?? []
                        ])
                        @if($key < (count($assessment_framework_questions) - 1))
                            <div class="separator separator-dashed mx-n5"></div>
                        @endif
                    @endforeach
                </form>
            </div>
        </div>
        <div class="d-flex flex-stack mt-5">
            <a class="btn btn-sm btn-secondary" href="/settings/assessments">Back</a>
            <button class="btn btn-sm btn-primary create_assessment_framework_question"
                data-assessment-framework-id="<?= $assessment_framework['encrypted_id']?>">Add a Question</button>
        </div>
    </div>
@endsection

@section('modals')
    @include('assessment-framework.components.create-assessment-framework-question-modal', ['assessment_framework_id' => $assessment_framework['encrypted_id']]);
    @include('assessment-framework.components.delete-assessment-framework-question-modal', ['assessment_framework_id' => $assessment_framework['encrypted_id']]);


@endsection

@section('javascript')
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script>
        $(document).ready(function () {

            var createQuestionOptionsRepeater = $('#create_assessment_framework_question_modal_form #question_options').repeater({
                initEmpty: false,
                isFirstItemUndeletable: true,
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });

            function resetQuestionForm(id) {
                $(id)[0].reset();
                $(id + ' .is-invalid').each(function () {
                    var input = $(this);
                    parent = input.closest('.mb-5');
                    input.removeClass('is-invalid');
                    parent.find('.select2-selection').removeClass('border-danger');
                    parent.find('.invalid-feedback').text('').hide();
                });
            }

            $('body').on('click', '.create_assessment_framework_question', function(){
                $('#create_assessment_framework_question_modal').modal('show');
            }) 

            $('body').on('click', '#create_assessment_framework_question', function(){
                var formData = $('#create_assessment_framework_question_modal_form').serializeArray();
                $.ajax({
                    url: $(this).data('url'),
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#create_assessment_framework_question_modal').modal('hide');
                        resetQuestionForm('#create_assessment_framework_question_modal_form');
                        $('#no_questions').hide();
                        questions = $('#assessment_framework_content form').children();
                        seperator = '<div class="separator separator-dashed mx-n5"></div>';
                        question = response.html;
                        if(questions.length > 1){
                           question = seperator + question;
                        }
                        questions.last().after(question);
                    },
                    error: function (response) {
                        errors = response.responseJSON.errors || {};
                        $.each(errors, function (key, value) {
                            var inputName = key.includes('.') ? key.replace(/\.(\d+)\./g, '[$1][').replace(/\./g, '][') + ']' : key; // Keep non-nested keys unchanged
                            var input = $('#create_assessment_framework_question_modal_form [name="' + inputName.replace(/(\[|\])/g, '\\$1') + '"]');
                            parent = input.closest('.mb-5');
                            input.addClass('is-invalid');
                            parent.find('.select2-selection').addClass('border-danger');
                            parent.find('.invalid-feedback').first().text(value[0]).show();
                        })
                    }
                })
            });

            $('body').on('click', '.edit_assessment_framework_question', function(e){
                e.preventDefault();
                $('#create_assessment_framework_question_modal').modal('show');
                
            })

            $('body').on('click', '.delete_assessment_framework_question', function(e){
                e.preventDefault();
                var assessmentFrameworkQuestionId = $(this).attr('data-assessment-framework-question-id');
                console.log(assessmentFrameworkQuestionId);
                $('#delete_assessment_framework_question_modal_form #assessment_framework_question_id').val(assessmentFrameworkQuestionId);
                $('#delete_assessment_framework_question_modal').modal('show');
            });

            $('body').on('click', '#delete_assessment_framework_question', function(){
                var assessmentFrameworkQuestionId = $('#delete_assessment_framework_question_modal_form #assessment_framework_question_id').val();
                var formData = $('#delete_assessment_framework_question_modal_form').serializeArray();
                console.log(formData);
                
                $.ajax({
                    url: $(this).data('url'),
                    type: 'DELETE',
                    data: formData,
                    success: function (response) {
                        var question = $('body #assessment_framework_question_'+assessmentFrameworkQuestionId);
                        var seperator = question.next();
                        question.remove();
                        seperator.remove();
                        if($('#assessment_framework_content form').children().length < 2){
                            $('#no_questions').show();
                        }
                        $('#delete_assessment_framework_question_modal').modal('hide');

                    }
                })
            });


        });
    </script>
@endsection