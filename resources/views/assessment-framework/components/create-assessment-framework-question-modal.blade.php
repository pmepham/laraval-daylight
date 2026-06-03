<div class="modal fade" tabindex="-1" id="create_assessment_framework_question_modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Create a Question</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-solid ki-cross fs-1"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="create_assessment_framework_question_modal_form" class="mb-0">
                    @csrf
                    <div class="mb-5">
                        <label class="form-label">Question <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Question name"
                            autocomplete="off">
                        <div class="invalid-feedback">Name is required.</div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">Question Type</label>
                        <select name="question_type" class="form-select" data-control="select2"
                            data-placeholder="Select an option" data-allow-clear="true">
                            @foreach($question_types as $key => $question_type):
                            <option value="<?= $key; ?>"><?= $question_type; ?></option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Question Type is required</div>
                    </div>

                    <!--begin::Repeater-->
                    <div id="question_options">
                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="form-label">Options</label>
                            <div data-repeater-list="question_options">
                                <div data-repeater-item>
                                    <div class="mb-5">
                                        <label class="form-label">Answer <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="hidden" name="option_id" value="">
                                        <div class="d-flex align-items-center">
                                            <input type="text" name="name" class="form-control me-2"
                                                placeholder="Answer" autocomplete="off">
                                            <a href="javascript:;" data-repeater-delete
                                                class="btn btn-flex btn-light-danger">
                                                <i class="ki-solid ki-cross fs-3"></i>Delete
                                            </a>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-5">
                            <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
                                <i class="ki-solid ki-plus fs-3"></i>
                                Add Answer
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button id="create_assessment_framework_question" type="button" class="btn btn-primary"
                    data-url="{{ route('assessment.framework.builder.create.question', ['id' => $assessment_framework_id]) }}">Save</button>
            </div>
        </div>
    </div>
</div>