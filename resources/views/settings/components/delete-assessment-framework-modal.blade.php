<div class="modal fade" tabindex="-1" id="delete_assessment_framework_modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Delete a Assessment Framework</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-solid ki-cross fs-1"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="delete_assessment_framework_modal_form" class="mb-0">
                    @csrf
                    <input type="hidden" name="id" value="">
                    <strong>Are you sure you want to delete this assessment framework?</strong>
                    <p>This action is permanent and cannot be undone. All data associated with this assessment will be permanently removed.</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button id="delete_assessment_framework" type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>