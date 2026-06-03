<div class="modal fade" tabindex="-1" id="delete_assessment_framework_question_modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Delete a Question</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-solid ki-cross fs-1"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="delete_assessment_framework_question_modal_form" class="mb-0">
                    @csrf
                    <input id="assessment_framework_question_id" type="hidden" name="assessment_framework_question_id" value="">
                    <div class="mb-5">
                        Are you sure you want to delete this question? <br>
                        Once deleted it cannot be recoved. <br>
                        This will not affect assessments that have been completed using the framework.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button id="delete_assessment_framework_question" type="button" class="btn btn-danger"
                    data-url="{{ route('assessment.framework.builder.delete.question') }}">Delete</button>
            </div>
        </div>
    </div>
</div>