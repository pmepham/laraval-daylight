<div class="modal fade" tabindex="-1" id="create_assessment_framework_modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Create a Assessment Framework</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-solid ki-cross fs-1"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="create_assessment_framework_modal_form" class="mb-0">
                    @csrf
                    <div class="mb-5">
                        <label class="form-label">Name <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Assessment framework name" autocomplete="off">
                        <div class="invalid-feedback">Name is required.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button id="create_assessment_framework" type="button" class="btn btn-primary" data-url="{{ route('settings.assessment.framework.create') }}">Save</button>
            </div>
        </div>
    </div>
</div>